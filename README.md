# Cadastro Laravel

Aplicação web para série de formulários de cadastro para pessoas idosas e/ou com deficiências (físicas/mentais/sociais), parecer técnico e serviços relacionados.

***

Web application for a series of forms related to health, deficiencies (phisical/mental/social), care treatment and related services.

***

##### @author baguy and André R. Timóteo

### Para inicializar o projeto
- clonar localmente
- criar banco de dados _cadastro_laravel_ (ou nome que preferir, mas lembre-se de mudar dentro do código sql também)
- rodar o código sql encontrado na pasta _inserts_ [cadastro_dump_05-06-2019.sql]
- abrir _cmd_ ou _git bash_ e inserir caminho da pasta do projeto local
- rodar _php artisan serve_
- no navegador, inserir _localhost:8000_ para ter acesso à página de login
- *usuário:* teste@gmail.com *senha:* 123456

##### Funcionalidades
- Pré-cadastro para usuários não cadastrados no sistema
- Cadastro completo
- Pareceres técnico de indivíduos
- Filtros de pesquisa
- Exportar pdf e tabela excel
- Envio de email para funcionários com email cadastrados
- Caixa de entrada separada em setores
- Atendimentos com status de _aberto_, _em andamento_ e _encerrado_
- Assentamentos para cada atendimento
