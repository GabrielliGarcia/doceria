<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Autenticar o usuário
        Auth::login($user);

        // Redirecionar ou retornar uma resposta
        return redirect()->route('vendas.index')->with('success', 'Registro concluído com sucesso!');
    }

    public function login(Request $request){
        // Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Verificar as credenciais e autenticar o usuário
        if (Auth::attempt($credentials)) {
            // Login bem-sucedido
            $request->session()->regenerate();

            return redirect()->route('vendas.index')->with('success', 'Login bem-sucedido!');
        }

        // Se as credenciais estiverem erradas
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('login.register');
    }
    
    public function showLoginForm()
    {
        return view('login.login');
    }
    
    public function minhaConta(){ 

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->withErrors('Você precisa estar logado para acessar sua conta.');
        }

        return view('login.minhaConta', compact('user'));
    }

    public function registrarAdmin(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Autenticar o usuário
        Auth::login($user);

        // Redirecionar ou retornar uma resposta
        return redirect()->route('loginAdmin')->with('success', 'Registro concluído com sucesso!');
    }

    public function loginAdmin(Request $request){
        // Validação dos dados
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Verificar as credenciais e autenticar o usuário
        if (Auth::attempt($credentials)) {
            // Login bem-sucedido
            $request->session()->regenerate();

            return redirect()->route('produto.index')->with('success', 'Login bem-sucedido!');
        }

        // Se as credenciais estiverem erradas
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }


    public function atualizarConta(Request $request){
        $user = Auth::user();

        // Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:20',
            'telefone' => 'nullable|string|max:20',
        ]);

        // Atualização dos dados do usuário
        \DB::table('users')->where('id', $user->id)->update($validatedData);

        return redirect()->route('minha-conta')->with('success', 'Informações atualizadas com sucesso!');
    }


}
