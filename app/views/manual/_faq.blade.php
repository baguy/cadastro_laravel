<div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
  <h5><i class="fas fa-question-circle"></i> Tire suas dúvidas</h5>
</div>

<div>


  {{-- Cadastro de funcionários --}}
  <div class="container">
    <div class="row">
      <button
        class="btn btn-secondary btn-toggle"
        type="button"
        data-toggle="collapse"
        data-target="#cadastroFuncionarios"
        aria-expanded="false"
        aria-controls="cadastroFuncionarios">
        <i class="fas fa-chevron-down"></i>
      </button>
          <h4 style="margin-top:5px;margin-left:5px;"><b>Cadastro de Funcionários</b></h4>
    </div>

    <div id="cadastroFuncionarios" class="collapse">
      <p style="padding:10px;">
        Para cadastrar novos usuários, acesse <i class="fas fa-user"></i> <b>Usuários</b>, depois <i class="far fa-dot-circle"></i> <b>Adicionar</b>. Preencha os campos e selecione os níveis de permissão.
        O usuário novo deverá acessar a página de login do sistema (página inicial) inserindo o email cadastrado e a senha padrão: 123456.
        Em seguida, o usuário será redirecionado para uma página na qual será requisitado inserir a senha atual (a senha padrão) e <b>criar uma senha nova</b>.
        <br>
        <i class="fas fa-angle-right" style="margin-right:10px;"></i> A nova senha deve conter, no mínimo, 10 dígitos, ao menos um caractere especial, ao menos uma letra e ao menos um número.
        <br>
        <i class="fas fa-angle-right" style="margin-right:10px;"></i> Ao se cadastrar um usuário, caso o campo <b>setor</b> seja preenchido, um funcionário será salvo com os mesmos dados, não sendo necessário recadastrar o usuário como funcionário. Apenas funcionários cadastrados recebem emails de novos atendimentos.
        <br>
        <i class="fas fa-angle-right" style="margin-right:10px;"></i> <b>Importante!</b> Cadastrar um funcionário não é o mesmo do que cadastrar um usuário. Para receber o login e a senha, deve-se cadastrar um usuário em <i class="fas fa-user"></i> <b>Usuários</b>.
      </p>
    </div>
  </div><!-- .Container -->


  {{-- Níveis de permissão --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#niveisPermissao"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Níveis de Permissão de Usuário</b></h4>
    </div>

      <div id="niveisPermissao" class="collapse">
        <p style="padding:10px;margin-top:5px;margin-bottom:0px;">
          <b>USER</b>
        </p>
        <p style="padding:10px;">
          Este nível de permissão permite o usuário cadastrar, editar e visualizar <i class="fas fa-user"></i> <b>Usuários</b>, <i class="fas fa-project-diagram"></i> <b>Setores</b>, <i class="fas fa-address-card"></i> <b>Funcionários</b>, <i class="fas fa-address-book"></i> <b>Atendimentos</b> e <i class="fas fa-users"></i> <b>Indivíduos</b>.
        </p>
        <p>
          <b style="padding:10px;">ADMIN</b>
        </p>
        <p style="padding:10px;">
          Este nível de permissão, além de ter acesso a todas as funcionalidades do USER, tem também acesso aos <i class="fas fa-database"></i> <b>Logs de Acesso</b>, pode <i class="fas fa-trash"></i> excluir e <i class="fas fa-recycle"></i> restaurar <i class="fas fa-user"></i> <b>Usuários</b>, <i class="fas fa-project-diagram"></i> <b>Setores</b>, <i class="fas fa-address-card"></i> <b>Funcionários</b>, <i class="fas fa-address-book"></i> <b>Atendimento</b> e <i class="fas fa-users"></i> <b>Indivíduos</b>.
        </p>
      </div>
    </div><!-- .Container -->


  {{-- Erro de cadastro --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#erroCadastro"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Erros de Cadastro</b></h4>
    </div>

    <div id="erroCadastro" class="collapse">
      <p style="padding:10px;">
        Em caso de erro de cadastro, certifique-se de ter preenchido todos os campos obrigatórios (sinalizados pelo asterisco <span class="obrigatorio">*</span>) e tente novamente. Também certifique-se de estar logado no sistema; caso o sistema fique parado por muito tempo, será necessário logar novamente (apenas recarregue a página para aparecer a tela de login). Caso o erro persista, entre em contato com a Secretaria de Tecnologia da Informação pelo telefone (12) 3897-1100.
      <br>
        <i class="fas fa-angle-right" style="margin-right:10px;"></i> Um funcionário só pode ser cadastrado se houver, pelo menos, um setor, já que é obrigatório incluir o funcionário em, pelo menos, um setor.
      <br>
        <i class="fas fa-angle-right" style="margin-right:10px;"></i> Atendimento só pode ser cadastrado se houver, pelo menos, um indivíduo cadastrado, já que é obrigatório incluir um indivíduo no atendimento.
      </p>
    </div>
  </div><!-- .Container -->


  {{-- Emails --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#envioEmail"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Envio de Emails</b></h4>
    </div>

    <div id="envioEmail" class="collapse">
      <p style="padding:10px;">
        Emails são enviados automaticamente para todos os funcionários do setor selecionado <b>após</b> o cadastro de um atendimento, somente se um setor for selecionado. Se dois funcionários forem cadastrados com emails iguais, apenas um receberá o email. Em caso de não recebimento de email, verifique se o funcionário foi cadastrado com o email correto.
        O sistema pode demorar um pouco para carregar quando precisar enviar emails para vários funcionários.
      </p>
    </div>
  </div><!-- .Container -->


  {{-- Excel --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#excel"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Exportar para Excel</b></h4>
    </div>

    <div id="excel" class="collapse">
      <p style="padding:10px;">
        Para exportar uma lista ou o resultado de uma pesquisa para Excel, clique no ícone <i class='fas fa-cog'></i> (Opções) e selecione a opção de Excel. O ícone <i class='fas fa-cog'></i> se encontra acima da tabela, à direita, na página principal de <i class="fas fa-users"></i> Indivíduos.
      </p>
    </div>
  </div><!-- .Container -->


  {{-- Excel --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#mapa"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Mapa</b></h4>
    </div>

    <div id="mapa" class="collapse">
      <p style="padding:10px;">
        Abra a aba <i class='fas fa-search'></i> <b>Pesquisar</b> para ter acesso ao botão <b>Mapa</b>, que irá redirecionar o usuário à página do mapa. Após ser redirecionado, é necessário clicar no botão <b>Buscar no mapa</b> (também na aba <i class='fas fa-search'></i> <b>Pesquisar</b>) para os marcadores serem exibidos em Caraguatatuba. Marcadores somente serão exibidos para <i class="fas fa-users"></i> <b>Indivíduos</b> ou <i class="fas fa-address-book"></i> <b>Atendimentos</b> com endereços corretamente cadastrados.
        <br>
          <i class="fas fa-angle-right" style="margin-right:10px;"></i> Clicar no marcador abre uma janela com informações do endereço.
      </p>
    </div>
  </div><!-- .Container -->


  {{-- Pré-Cadastro --}}
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#precadastro"><i class="fas fa-chevron-down"></i></button>
        <h4 style="margin-top:5px;margin-left:5px;"><b>Pré-Cadastro</b></h4>
    </div>

    <div id="precadastro" class="collapse">
      <p style="padding:10px;">
        É possível realizar o pré-cadastro sem estar logado no sistema pelo endereço [endereço da aplicação]/pre_cadastro.
      </p>
    </div>
  </div><!-- .Container -->

</div>
