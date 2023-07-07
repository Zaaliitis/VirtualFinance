<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Crypto\CryptoRepository;
use App\Models\Crypto\CryptoWallet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IndexCryptoController extends Controller
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(Request $request): View
    {
        $cryptoCurrencies = $this->cryptoRepository->getCacheCurrencies();
        $search = $request->input('search');
        $cryptoCurrencies = $this->filterCryptoCurrencies($cryptoCurrencies, $search);
        $cryptoCurrenciesPaginated = $this->paginateCryptoCurrencies($cryptoCurrencies);
        $userHasWallet = $this->checkUserWallet();

        return view('crypto.index', [
            'cryptoCurrencies' => $cryptoCurrenciesPaginated,
            'userHasWallet' => $userHasWallet
        ]);
    }

    private function filterCryptoCurrencies(array $cryptoCurrencies, $search): array
    {
        if ($search) {
            $search = strtolower($search);
            $cryptoCurrencies = array_filter($cryptoCurrencies, function ($currency) use ($search) {
                return str_contains(strtolower($currency->symbol), $search);
            });
        }
        return $cryptoCurrencies;
    }

    private function paginateCryptoCurrencies(array $cryptoCurrencies): LengthAwarePaginator
    {
        $perPage = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = array_slice($cryptoCurrencies, ($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $currentItems,
            count($cryptoCurrencies),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }

    private function checkUserWallet(): bool
    {
        return CryptoWallet::where('user_id', Auth::id())->exists();
    }

}
