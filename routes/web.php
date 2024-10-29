<?php

use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;

Route::group(['prefix' => 'categoria'], function(){
    Route::get('/',[CategoriaController::class,'index']);
    Route::get('/novo',[CategoriaController::class,'inserir']);    
    Route::post('/novo',[CategoriaController::class,'salvar_novo']);   
    Route::get('/excluir/{id}',[CategoriaController::class,'excluir']);
    Route::get('/update/{id}',[CategoriaController::class,'alterar']);
    Route::post('/update',[CategoriaController::class,'salvar_update']);
});



Route::group(['prefix' => 'produto'], function(){
    Route::get('/',[ProdutoController::class,'index'])->name('produto.index');
    Route::get('/novo',[ProdutoController::class,'inserir']);   
    Route::post('/novo',[ProdutoController::class,'salvar_novo']);
    Route::get('/excluir/{id}',[ProdutoController::class,'excluir']);
    Route::get('/update/{id}',[ProdutoController::class,'alterar']);
    Route::post('/update',[ProdutoController::class,'salvar_update']);
});



Route::group(['prefix' => 'vendas'], function(){
    Route::get('/',[VendasController::class,'index']); 
    Route::get('/comprar/{id}',[VendasController::class,'comprar']);    
    Route::get('/categoria/{id}', [VendasController::class, 'searchCategoria']);   
    Route::get('/carrinho/{id}', [VendasController::class, 'adicionarAoCarrinho'])->name('adicionar-ao-carrinho');
    Route::get('/exibir-carrinho', [VendasController::class, 'exibirCarrinho'])->name('exibir-carrinho');  
    Route::get('/carrinho/remover/{id}', [VendasController::class, 'removeItemParcial'])->name('remover-do-carrinho'); 
    Route::get('/carrinho/excluir/{id}', [VendasController::class, 'excluiItem'])->name('excluir-item'); 
    Route::post('/finalizar-compra', [VendasController::class, 'finalizarCompra']);  
});

Route::group(['prefix' => 'compras'], function(){
    Route::get('/',[ComprasController::class,'index']);    
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/', [VendasController::class, 'index'])->name('vendas.index');

Route::middleware(['auth'])->get('/minha-conta', [AuthController::class, 'minhaConta'])->name('minha-conta');

Route::get("/registrarAdmin", function() {
    return view ("templateAdmin.registrarAdmin");
})->name('registrarAdmin');
Route::post("/registrarAdmin", [AuthController::class, 'registrarAdmin']);

Route::get("/loginAdmin", function() {
    return view ("templateAdmin.loginAdmin");
})->name('loginAdmin');
Route::post("/loginAdmin", [AuthController::class, 'loginAdmin'])->name('loginAdmin');

Route::middleware('auth')->group(function () {
    Route::get('/produto', [ProdutoController::class, 'index'])->name('produto.index');
    // outras rotas que precisam de autenticação
});

Route::post('/vendas/finalizar-compra', [CheckoutController::class, 'criarPagamento']);

Route::get('/minha-conta', [AuthController::class, 'minhaConta'])->middleware('auth')->name('minha-conta');

Route::post('/minha-conta/atualizar', [AuthController::class, 'atualizarConta'])->middleware('auth')->name('minha-conta.atualizar');
