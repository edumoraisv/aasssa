<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Concursos\Model\Repositories\Eloquent\CandidatosRepository;
use Concursos\Helpers\TransformadorDadosDefault;

class EloquentCandidatosRepositoryTest extends TestCase
{
    
    use DatabaseMigrations;
    
    private $candidatosRepository;
    private $novoCandidato;
    private $transformador;
    
   
    
    public function setUp() {
        parent::setUp();
        
        $this->artisan('db:seed', ['--class' => 'LogradourosSeeder']);
        $this->artisan('db:seed', ['--class' => 'EstadosSeeder']);
        $this->artisan('db:seed', ['--class' => 'CidadesSeederTest']);
        
        $this->transformador = new TransformadorDadosDefault();
        $this->candidatosRepository = new CandidatosRepository($this->transformador);
        
        
    }
    
    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testConsultarPorIdInexistente() {
        $this->candidatosRepository->findBy('id',1000000);
    }
    
    public function testConsultarPorIdExistente() {
        
        $this->novoCandidato['nome'] = 'Francisco Chagas Alexandre de Souza Filho';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['email'] = 'glamreboucas@gmail.com';
        $this->novoCandidato['senha'] = 'aaaaaaaaa';
        $this->novoCandidato['telefone_residencial'] = '01332232416';
        $this->novoCandidato['telefone_celular'] = '013996511476';
        $this->novoCandidato['cpf'] = '67483406089';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Jos?? Jatahy';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Farias Brito';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        
        $candidato = $this->candidatosRepository->findBy('id',1);
        $this->assertEquals(1, $candidato['id']);
        $this->assertArrayHasKey('nome', $candidato);
        $this->assertArrayHasKey('nascimento', $candidato);
        $this->assertArrayHasKey('cpf', $candidato);
    }
    
    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testConsultarPorEmailInexistente() {
        $this->candidatosRepository->findBy('email', 'blablabla');
    }
    
    public function testConsultarPorEmailExistente() {
        
        $this->novoCandidato['nome'] = 'Francisco Chagas Alexandre de Souza Filho';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['email'] = 'glamreboucas@gmail.com';
        $this->novoCandidato['senha'] = 'g';
        $this->novoCandidato['telefone_residencial'] = '01332232416';
        $this->novoCandidato['telefone_celular'] = '013996511476';
        $this->novoCandidato['cpf'] = '67483406089';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Jos?? Jatahy';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Farias Brito';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        $candidato = $this->candidatosRepository->findBy('email', 'glamreboucas@gmail.com');
        $this->assertEquals('glamreboucas@gmail.com', $candidato['email']);
        
    }
    
    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testConsultarPorCPFInexistente() {
        $this->candidatosRepository->findBy('cpf','blablabla');
    }
    
    public function testConsultarPorCPFExistente() {
        
        $this->novoCandidato['nome'] = 'Francisco Chagas Alexandre de Souza Filho';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['email'] = 'alexfiofcasf@gmail.com';
        $this->novoCandidato['senha'] = 'm';
        $this->novoCandidato['telefone_residencial'] = '01332232416';
        $this->novoCandidato['telefone_celular'] = '013996511476';
        $this->novoCandidato['cpf'] = '67483406089';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Jos?? Jatahy';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Farias Brito';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        $candidato = $this->candidatosRepository->findBy('cpf','67483406089');
        $this->assertEquals('67483406089', $candidato['cpf']);
        
    }
    

    public function testCriarNovoCandidato() {
        $this->novoCandidato['nome'] = 'Francisco Chagas Alexandre de Souza Filho';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['email'] = 'alexfiofcasf@gmail.com';
        $this->novoCandidato['senha'] = 'a';
        $this->novoCandidato['telefone_residencial'] = '01332232416';
        $this->novoCandidato['telefone_celular'] = '013996511476';
        $this->novoCandidato['cpf'] = '67483406088';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Jos?? Jatahy';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Farias Brito';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        $this->assertInternalType('int', $idCandidato);
        
        $candidato = $this->candidatosRepository->findBy('id', $idCandidato);
        
        $this->assertEquals('67483406088', $candidato['cpf']);
        
    }
    
    /**
     * @expectedException Exception
     */
    public function testCriarNovoCandidatoComCpfJaCadastrado() {
        
        //Supondo que este registro j?? est?? no banco de dados
        
        $this->novoCandidato['nome'] = 'Adriana Mena Rebou??as';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','08/03/1975');
        $this->novoCandidato['email'] = 'glamreboucas@gmail.com';
        $this->novoCandidato['senha'] = 'a';
        $this->novoCandidato['telefone_residencial'] = '01132232416';
        $this->novoCandidato['telefone_celular'] = '011996511476';
        $this->novoCandidato['cpf'] = '67483406089';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Campinas';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Higien??polis';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
         
    }
    
    public function testFindByCriteriaEncontrou() {
        //Supondo que este registro j?? est?? no banco de dados
        
        $this->novoCandidato['nome'] = 'Fl??via Adriana';
        $this->novoCandidato['nascimento'] =  DateTime::createFromFormat('d/m/Y','08/03/1975');
        $this->novoCandidato['email'] = 'glamreboucas@gmail.com';
        $this->novoCandidato['senha'] = 'g';
        $this->novoCandidato['telefone_residencial'] = '01132232416';
        $this->novoCandidato['telefone_celular'] = '011996511476';
        $this->novoCandidato['cpf'] = '67483406089';
        $this->novoCandidato['rg'] = '3003004000246';
        $this->novoCandidato['rg_org_exp'] = 'SSP';
        $this->novoCandidato['rg_uf'] = 25;
        $this->novoCandidato['rg_data_expedicao'] = DateTime::createFromFormat('d/m/Y','17/08/1986');
        $this->novoCandidato['cidade'] = 4850;
        $this->novoCandidato['tipo_logradouro'] = 1;
        $this->novoCandidato['logradouro'] = 'Campinas';
        $this->novoCandidato['numero'] = '1533';
        $this->novoCandidato['cep'] = '60020295';
        $this->novoCandidato['bairro'] = 'Higien??polis';
        $idCandidato = 
          $this->candidatosRepository->saveOrUpdate($this->novoCandidato); 
        
        $criterios = ['nome' => '%Adriana%', 'cpf' => '67483406089'];
        $cands = $this->candidatosRepository->findByCriteria($criterios, 0, 10);
        $this->assertArrayHasKey('nome', $cands[0]);
    }
}
