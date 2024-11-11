<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Set timezone
            config(['app.timezone' => 'Asia/Jakarta']);
            
            // Mulai query dengan eager loading
            $query = Transaction::query()->with(['inventory' => function($q) {
                $q->select('id', 'nama_barang', 'kode_barang');
            }]);

            // Filter berdasarkan periode
            if ($request->filled('period')) {
                switch ($request->period) {
                    case 'today':
                        $query->whereDate('created_at', Carbon::today());
                        break;
                    case 'yesterday':
                        $query->whereDate('created_at', Carbon::yesterday());
                        break;
                    case 'this_week':
                        $query->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(),
                            Carbon::now()->endOfWeek()
                        ]);
                        break;
                    case 'last_week':
                        $query->whereBetween('created_at', [
                            Carbon::now()->subWeek()->startOfWeek(),
                            Carbon::now()->subWeek()->endOfWeek()
                        ]);
                        break;
                    case 'this_month':
                        $query->whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year);
                        break;
                    case 'last_month':
                        $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                              ->whereYear('created_at', Carbon::now()->subMonth()->year);
                        break;
                    case 'this_year':
                        $query->whereYear('created_at', Carbon::now()->year);
                        break;
                }
            }
            // Filter by specific date if set
            elseif ($request->filled('date_end')) {
                $query->whereDate('created_at', Carbon::parse($request->date_end));
            }

            // Filter by nama barang
            if ($request->filled('search_name')) {
                $query->whereHas('inventory', function($q) use ($request) {
                    $q->where('nama_barang', 'like', '%' . $request->search_name . '%');
                });
            }

            // Filter by kode barang
            if ($request->filled('search_code')) {
                $query->whereHas('inventory', function($q) use ($request) {
                    $q->where('kode_barang', 'like', '%' . $request->search_code . '%');
                });
            }

            // Sort by column
            $sortColumn = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            // Validate allowed columns for sorting
            $allowedColumns = ['inventory_id', 'jumlah', 'total_harga', 'created_at'];
            if (in_array($sortColumn, $allowedColumns)) {
                $query->orderBy($sortColumn, $sortDirection);
            } else {
                $query->latest();
            }

            // Execute query with pagination
            $transactions = $query->paginate(10);
            
            // Merge query string parameters
            if ($request->hasAny(['search_name', 'search_code', 'period', 'date_end', 'sort', 'direction'])) {
                $transactions->appends($request->all());
            }

            // Calculate summary
            $summary = [
                'total_transactions' => $transactions->total(),
                'total_amount' => $query->sum('total_harga'),
                'total_items' => $query->sum('jumlah'),
                'average_amount' => $query->avg('total_harga') ?? 0
            ];

            return view('admin.transactions.index', compact('transactions', 'summary'));

        } catch (\Exception $e) {
            Log::error('Transaction Index Error: ' . $e->getMessage());
            
            return view('transactions.index', [
                'transactions' => collect([]),
                'summary' => [
                    'total_transactions' => 0,
                    'total_amount' => 0,
                    'total_items' => 0,
                    'average_amount' => 0
                ]
            ])->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function export()
    {
        $transactions = Transaction::with('inventory')->get();
        
        // Generate CSV filename
        $filename = 'transactions-' . now()->format('Y-m-d') . '.csv';

        // Stream the CSV response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ];

        $callback = function() use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Barang', 'Jumlah', 'Total Harga', 'Tanggal']);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    $transaction->inventory->nama_barang,
                    $transaction->jumlah,
                    $transaction->total_harga,
                    $transaction->created_at->format('d M Y H:i:s')
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
