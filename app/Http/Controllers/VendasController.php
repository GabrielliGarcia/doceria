<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Vendas;
use Illuminate\Support\Facades\Session;
use App\Classes\Carrinho;

use Illuminate\Http\Request;

class VendasController extends Controller
{
    public function index(){
        //$produto = Produto::all()->toArray();
        
           $vendas = Produto::select("produto.id",
                                       "produto.nome",
                                       "produto.preco",
                                       "categoria.nome AS cat",
                                       "produto.descricao",
                                       "produto.imagem")
                                    ->join("categoria","categoria.id", "=", "produto.id_categoria")
                                    ->orderBy("produto.id") 
                                    ->get();

            $categorias = Categoria::all()->toArray();    

        return view("Vendas.index",["vendas"=>$vendas,'categorias' => $categorias]);
    }

    public function comprar($id){    
        $produto = Produto::find($id)->toArray();
        $categorias = Categoria::all()->toArray();  //select de categorias - laravel            
        return View("Vendas.comprar",['produto'=>$produto,'categorias' => $categorias]);             
    }

    public function carrinho($id){    
        $produto = Produto::find($id)->toArray();
        $categorias = Categoria::all()->toArray();  //select de categorias - laravel
  
        

        return View("Vendas.carrinho",['produto'=>$produto,'categorias' => $categorias]);             
    }


    public function searchCategoria($id){    
        $vendas = Produto::select("produto.id",
                                  "produto.nome",
                                  "produto.preco",
                                  "categoria.nome AS cat",
                                  "produto.descricao",
                                  "produto.imagem")
                          ->join("categoria","categoria.id", "=", "produto.id_categoria")
                          ->where("categoria.id", "=", $id)
                          ->orderBy("produto.id") 
                          ->get();
    
        $categorias = Categoria::all()->toArray();    
    
        return view("Vendas.index", ["vendas" => $vendas, 'categorias' => $categorias]);
    }   

    public function adicionarAoCarrinho($id)
    {
    // Recupere os detalhes do produto do banco de dados usando o ID
    $produto = Produto::find($id);

    // Verifique se o produto foi encontrado
    if (!$produto) {
        return redirect()->route('vendas.index')->with('error', 'Produto não encontrado!');
    }

    // Inicialize o carrinho
    $carrinho = session('carrinho', []);

    // Verifique se o produto já está no carrinho
    $produtoNoCarrinho = false;

    // Percorra o carrinho para verificar se o produto já está presente
    foreach ($carrinho as $key => $item) {
        if ($item['id'] == $produto->id) {
            $produtoNoCarrinho = true;
            break;
        }
    }    

    // Se o produto não estiver no carrinho, adicione-o
    if (!$produtoNoCarrinho) {
        $novoItem = [
            'id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => $produto->preco,
            'imagem' => $produto->imagem,
            // Adicione outros detalhes do produto, se necessário
        ];
        $carrinho[] = $novoItem;
    }

    // Atualize o carrinho na sessão
    session(['carrinho' => $carrinho]);

    // Redirecione para a página de exibição do carrinho
    return redirect()->route('exibir-carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }   

    public function removeItemParcial($id){
        $produto = Produto::find($id);
        $carrinho = session('carrinho', []);

        foreach ($carrinho as $key => $item) {
            if ($item['id'] == $produto->id) {
                // Diminui a quantidade
                $carrinho[$key]['quantidade'] -= 1;   
                
                // Remove o item se a quantidade for zero
                if ($carrinho[$key]['quantidade'] <= 0) {
                    unset($carrinho[$key]);
                }
                break;
            }
        }  

        session(['carrinho' => $carrinho]);
        return redirect()->route('exibir-carrinho')->with('success', 'Item parcialmente removido');
    }

    public function excluiItem($id){
        $produto = Produto::find($id);
        $carrinho = session('carrinho', []);

        foreach ($carrinho as $key => $item) {
            if ($item['id'] == $produto->id) { 
                    unset($carrinho[$key]);                
                break;
            }
        }  

        session(['carrinho' => $carrinho]);
        return redirect()->route('exibir-carrinho')->with('success', 'Item removido');
    }


    public function exibirCarrinho()
    {
        // Recupere o conteúdo do carrinho da sessão
        $carrinho = Session::get('carrinho', []);
        $categorias = Categoria::all()->toArray();  

        
        return view('vendas.carrinho', ['carrinho' => $carrinho,'categorias' => $categorias]);
    }

    public function finalizarCompra(Request $request){
        
        // Obter os itens da sessão carrinho
        $carrinho = session()->get('carrinho');
        var_dump($carrinho);
        // Verificar se o carrinho não está vazio
        if (!empty($carrinho)) {
    
            // Iterar sobre os itens do carrinho e salvar no banco de dados
            foreach ($carrinho as $item) {                
                $venda = new Vendas();
                $venda->email = $request->input("email");
                $venda->codigo_produto = $item['id'];
                $venda->save();
            }
    
            // Limpar a sessão do carrinho após salvar no banco de dados
            session()->forget('carrinho');
        }
        
        return redirect("/vendas");         
    }
    
}
