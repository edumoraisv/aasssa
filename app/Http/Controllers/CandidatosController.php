<?php

namespace Concursos\Http\Controllers;

use Illuminate\Http\Request;
use Concursos\Modules\CandidatosInterface;
use Concursos\Http\Requests\CandidatoCadastroRequest;
use Concursos\Http\Requests\CandidatoAtualizacaoRequest;
use Concursos\Exceptions\CandidatoJaCadastradoException;
use Concursos\Exceptions\ResultadoVazioException;
use Concursos\Modules\EstadosInterface;

class CandidatosController extends Controller {

    private $moduloCandidatos;
    private $moduloEstados;
    
    public function __construct(
            CandidatosInterface $moduloCandidatos, 
            EstadosInterface $moduloEstados) {
        
        $this->moduloCandidatos = $moduloCandidatos;
        $this->moduloEstados = $moduloEstados;
    }

    public function index() {
        return view('candidatos.index');
    }

    public function carregarViewCadastrar() {
        return view('candidatos.cadastro');
    }
    
    public function carregarViewEditar($id) {
        $criterios['id'] = $id;
        $dados['candidato'] = 
                $this->moduloCandidatos
                ->consultar($criterios, 1, 1)['candidatos'][0];
        
        $dados['cidades'] = $this->moduloEstados->obterCidadesByEstado($dados['candidato']['estado']['id']);
        return view('candidatos.cadastro', $dados);
    }
    
    
    //Carrega os dados de candidato de forma detalhad
     public function carregarViewConsultar($id) {
        $criterios['id'] = $id;
        $dados['candidato'] = 
                $this->moduloCandidatos
                ->consultar($criterios, 1, 1)['candidatos'][0];
        $dados['cidades'] = $this->moduloEstados->obterCidadesByEstado($dados['candidato']['estado']['id']);
        $dados['apenasConsulta'] = true;
        return view('candidatos.cadastro', $dados);
    }

    public function carregarViewConsulta() {
        return view('candidatos.consultar');
    }

    public function cadastrar(CandidatoCadastroRequest $request) {
        
        try {
            
            $this->moduloCandidatos->cadastrarOuAtualizar($request->all());
            $entrada['feedback'] = "Candidato Cadastrado com Sucesso !";
            
            return redirect()->action("CandidatosController@index")
                             ->withInput($entrada);
            
        } catch (CandidatoJaCadastradoException $ex) {
            $entrada = $request->all();
            $entrada['jaCadastrado'] = true;
            return redirect()->action("CandidatosController@carregarViewCadastrar")
                             ->withInput($entrada);
            
        } catch (\Exception $ex) {
            $entrada = $request->all();
            $entrada['excecaoGenerica'] = true;
            return redirect()->action("CandidatosController@carregarViewCadastrar")
                             ->withInput($entrada);
        }
    }
    
    
    public function atualizar(CandidatoAtualizacaoRequest $request) {
        
        try {
            
            $this->moduloCandidatos->cadastrarOuAtualizar($request->all());
            $entrada['feedback'] = "Candidato Atualizado com Sucesso !";
    
            return redirect()->action("CandidatosController@index")
                             ->withInput($entrada);
        }    
        catch (\Exception $ex) {
            $entrada = $request->all();
            $entrada['excecaoGenerica'] = true;
            return redirect()->action("CandidatosController@carregarViewCadastrar")
                             ->withInput($entrada);
        }
    }
    
        
    
    
    public function consultar(Request $request) {
       try{
           
           $pagina = $request->input('pg', 1);
           
           //Quantidade de Registros pro p??gina
           $qtdPorPagina = $request->input('qtdPorPg', 15);
           
           $criterios = $request->except(['_token', 'pg', 'qtdPorPg']);
           
           $data = $this->moduloCandidatos
                   ->consultar($criterios, $pagina, $qtdPorPagina);
           
           if(count($data['candidatos']) < 1) {
               throw new ResultadoVazioException();
           }
           
           $dados['candidatos'] = $data['candidatos'];
           $dados['qtdPaginas'] = ceil($data['qtdCandidatosConsulta']/$qtdPorPagina);
           
           //Convertendo array de criterios para o formato query string
           $dados['criterios'] = http_build_query($criterios);
           $dados['paginaAtual'] = $pagina;
           $dados['qtdPorPg'] = $qtdPorPagina;
           
           return redirect()->action("CandidatosController@carregarViewConsulta")
                            ->withInput($dados + $criterios);
           
           
       } catch (\InvalidArgumentException $ex) {
           $entrada['feedback'] = 'Pelo menos um crit??rio de busca deve submetido.';
           return redirect()
                  ->action("CandidatosController@carregarViewConsulta")
                  ->withInput($entrada);
       }
       catch (ResultadoVazioException $ex) {
           $entrada['feedback'] = 'A consulta n??o retornou resultados.';
           return redirect()
                  ->action("CandidatosController@carregarViewConsulta")
                  ->withInput($entrada);
       }
    }

}
