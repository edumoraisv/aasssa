@extends('commons.template')

@section('titulo')
Sistema de Gerenciamento de Concursos
@endsection

@section('conteudo')
<div class ="container">
    <br>
    <div class ="row">
        <div class ='card-panel col s12 m12 l12 teal white-text'>
            <h4>
                Consultar Candidato
            </h4>
        </div>
    </div>
    
    <div class ="row">
        <div class ="col s12 m12 l12">
            <form action = "{{action('CandidatosController@consultar')}}" 
                  method = "post">
                
                <input  type ="hidden" 
                        name = "_token" 
                        value ="{{csrf_token()}}">
                
                <div class ="row card-panel">
                    <div class ="col s12 m12 l12">
                        <div class = "row">
                            <div class = 'input-field col s12 m12 l6'>
                                <label for = "campoNome">Nome</label>
                                <input id = "campoNome" 
                                       name = "nome" 
                                       type = "text" 
                                       value = "{{old('nome')}}">
                            </div>
                            <div class = 'input-field col s12 m12 l3'>
                                <label for = "campoCPF">CPF</label>
                                <input id = "campoCPF" 
                                       name = 'cpf' 
                                       type = "text" 
                                       value = "{{old('cpf')}}">
                            </div>
                            <div class = "input-field col s12 m12 l3">

                                <select name = "sexo">
                                    <option  value=""  selected ></option>
                                    @foreach($componentes['sexo'] as $sexo)
                                    <option 
                                        <?= old('sexo') == $sexo['id'] ? "selected" : "" ?> 
                                        value = "{{$sexo['id']}}">{{$sexo['nome']}}</option>
                                    @endforeach
                                </select>
                                <label>Sexo</label>

                            </div>
                        </div>
                        <div class = "row">
                            <div class = "input-field col s12 m12 l4">
                                <select name = "estado">
                                    <option  value="" disabled selected ></option>
                                    @foreach($componentes['estados'] as $estado)
                                    <option <?= old('estado') == $estado['id'] ? 'selected' : '' ?> 
                                        value = "{{$estado['id']}}">{{$estado['nome']}}</option>
                                    @endforeach
                                </select>
                                <label>Estado</label>
                            </div>
                            <div class = "input-field col s12 m12 l2">
                                <select name = "qtdPorPg">
                                    <option  value="" disabled selected ></option>
                                    @for($c = 5; $c <= 50; $c+=15)
                                    <option 
                                    <?= old('qtdPorPg') == $c ? 'selected' : '' ?> 
                                    value = "{{$c}}">{{$c}}</option>
                                    @endfor
                                </select>
                                <label>Registros/P??gina</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = 'row'>
                    <div class ="col s6 m6 l6   ">
                        <a href ="{{action('CandidatosController@carregarViewConsulta')}}" 
                           class = 'btn teal waves-effect waves-light btn col s6 m6 l6 left'>
                            <i class="material-icons left">settings_backup_restore</i>
                            Limpar Crit??rios
                        </a>

                    </div>
                    <div class ='col s6 m6 l6'>               
                        <button type ="submit" 
                                class = 'btn teal waves-effect waves-light btn col s6 m6 l6 right'>
                            <i class="material-icons left">search</i>
                            Consultar
                        </button>
                    </div>
                </div>
            </form>
         </div>
    </div>
    @if(old('feedback'))
    <div class ="row animated fadeIn">
        <div class ="card-panel col s12 m12 l12 yellow lighten-4">
            <h5>
                {{old('feedback')}}
            </h5>
        </div>
    </div>
    @endif

    @if(old('candidatos') && count(old('candidatos')) > 0 )
    <ul class="pagination">
    
        <li class="{{ old('paginaAtual') == 1 ? 'disabled' : 'waves-effect'}}">
            <a  href="{{ old('paginaAtual') == 1 ? '#' : action('CandidatosController@consultar')}}?qtdPorPg={{old('qtdPorPg')}}&pg={{old('paginaAtual') - 1}}&{{old('criterios')}}">
                <i class="material-icons">chevron_left</i>
            </a>
        </li>

    @for($p = 1; $p <= old('qtdPaginas'); $p++)
        <li  class = "{{ old('paginaAtual') == $p ? 'active teal' :  'waves-effect' }}" >
            <a href="{{action('CandidatosController@consultar')}}?qtdPorPg={{old('qtdPorPg')}}&pg={{$p}}&{{old('criterios')}}">
                {{$p}}
            </a>
        </li>   
    @endfor
    
        <li class="{{ old('paginaAtual') == old('qtdPaginas') ? 'disabled' : 'waves-effect'}}">
            <a  href="{{ old('paginaAtual') == old('qtdPaginas') ? '#' : action('CandidatosController@consultar')}}?qtdPorPg={{old('qtdPorPg')}}&pg={{old('paginaAtual') + 1}}&{{old('criterios')}}">
                <i class="material-icons">chevron_right</i>
            </a>
        </li>
    
    </ul>
    <div class ='row animated fadeIn'>
        <div class = "col s12 m12 l12">
            <table class = "bordered striped responsive-table card-panel">
                <thead>
                    <tr>
                        <th data-field="id">Identificador</th>
                        <th data-field="name">Nome</th>
                        <th data-field="price">CPF</th>
                        <th data-field="action">A????es</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(old('candidatos') as $candidato)
                    <tr>
                        <td>{{app('Concursos\Helpers\TransformadorDadosInterface')
                                   ->completarNumeroComZerosAEsquerda($candidato['id'])}}</td>
                        <td>{{$candidato['nome']}}</td>
                        <td>{{app('Concursos\Helpers\TransformadorDadosInterface')
                                   ->adicionarMascaraCPF($candidato['cpf'])}}
                        </td>
                        <td>
                            <a  class="waves-effect waves-teal btn-flat small tooltipped"
                                data-position="top" data-delay="50" data-tooltip="Exibir Detalhes"
                                href = "{{action('CandidatosController@carregarViewConsultar', $candidato['id'])}}">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>
                            
                            <a  
                                class="waves-effect waves-teal btn-flat tooltipped"
                                data-position="top" data-delay="50" data-tooltip="Alterar Dados"
                                href = "{{action('CandidatosController@carregarViewEditar', $candidato['id'])}}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            
                            <a 
                                id ="candidato-{{$candidato['id']}}"
                                data-position="top" data-delay="50" data-tooltip="Enviar E-mail"
                                class="waves-effect waves-teal btn-flat modal-trigger tooltipped"
                                href="#modal1">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </a>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 
    </div>

    @endif

  <!-- Estrutura do Modal -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
          Enviar E-mail
      </h4>
        <div id ='preloader' class ='row' style = 'display:none'>
            <div class ='col s12 m12 l12'>
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>

            </div>
        </div>  
      <div class = "row">
          <div class ="input-field col s12 m12 l12">
                <label for = "campoDestinatario">Destinat??rio</label>
                <input id ="campoDestinatario" 
                       type ="text" 
                       name = "destinatario" 
                       placeholder=""
                       disabled>
            </div>
            <div class ="input-field col s12 m12 l12">
                <label for = "campoAssunto">Assunto</label>
                <input id = "campoAssunto" type ="text" name = "assunto" placeholder="">
            </div>
          <div class ="input-field col s12 m12 l12">
                
              <textarea 
                  id ="campoCorpo"
                  placeholder=""
                  style = "min-height: 34%; max-height: 34%; "
                  id="campoCorpo" 
                  class="materialize-textarea" 
                  cols="50" rows = "100"></textarea>
              <label for = "campoCorpo">Corpo</label>
            </div>
            
       </div>
    </div>
    <div class="modal-footer">
        <a id ="botaoEnviarEmail"
            href="#!"
           class="modal-action waves-effect waves-green btn-flat ">
            Enviar
        </a>
        <a href="#!" 
           id ="botaoCancelarEmail"
           class="modal-action modal-close waves-effect waves-green btn-flat ">
            Cancelar
        </a>
    </div>
  </div>
    
</div>
@endsection

@section('scripts')
@parent
<script src = "{{url('js/candidatos/consulta.js')}}" type = 'text/javascript'>
</script>
@endsection