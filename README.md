<!-- # Logo ou Banner -->
<!-- <p align="center">
   <img src="https://trello-attachments.s3.amazonaws.com/5c3b9c9903d1b107b15a5271/182x42/078f443628a4ad74cafa0b01f44b4a7f/ppclogov1-2.png" alt="PPC Choice" width="280"/>
</p> -->

# :rocket: dev.api.ppcchoice.ufes.br
[![PHP](https://img.shields.io/static/v1?label=PHP&message=5.35&colorA=purple&color=black&logo=PHP&logoColor=white)](https://www.php.net/) [![CodeIgniter](https://img.shields.io/static/v1?label=CodeIgniter&message=v3&colorA=darkred&color=black&logo=CodeIgniter&logoColor=white)](https://codeigniter.com/) [![Apidocjs](https://img.shields.io/static/v1?label=apiDocJS&message=1.26.3&colorA=pink&color=black&logo=javascript&logoColor=white)](https://apidocjs.com/) [![MySQL](https://img.shields.io/static/v1?label=MySQL&message=9&colorA=darkblue&color=black&logo=mysql&logoColor=white)](https://mysql.com/) [![Symfony Doctrine ORM](https://img.shields.io/static/v1?label=Symfony%20Doctrine&message=6.0&colorA=blue&color=black&logo=symfony)](https://www.doctrine-project.org/) [![PHPUnit](https://img.shields.io/static/v1?label=PHPUnit&message=7.0&colorA=blue&color=black&logo=PHP&logoColor=white)](https://phpunit.de/) [![GuzzleHTTP](https://img.shields.io/static/v1?label=Guzzle%20HTTP&message=1.3.1&colorA=blue&color=black&logo=PHP&logoColor=white)](http://docs.guzzlephp.org/en/stable/)


## :book: Descrição 
API RESTful construída para consumo interno do projeto [PPC Choice](http://ppcchoice.ufes.br), uma aplicação *web* de comparação e visualização de Projetos Pedagógicos de Curso e fornece dados dos seguintes recursos:
- Instituições de Ensino (Superior)
- Unidades de Ensino
- Departamentos da unidade de ensino
- Componentes curriculares 
- Cursos
- Projetos Pedagógicos de Curso (PPC)

Você pode acessar mais detalhes na seção [Documentação](./#books-documentacao)

## :computer: Status do Projeto 

	🚧 🚀 Em construção ...  🚧

### Sumário

* [Documentação](#books-Documentação-da-API)
* [Demonstração](#dark_sunglasses-Demonstração-da-aplicação)
* [Problemas](#ghost-Problemas)
* [Contribuição](#balloon-Contribuição)
  * [Pré-requisitos e limitações](#1. pushpin-Pré-requisitos-e-limitações)
  * [Fork este repositório e realize alterações](#2.-fork_and_knife-Fork-este-repositório-e-realize-alterações)
  * [Planeje e execute testes](#3.-clipboard-Planeje-e-execute-testes)
  * [Solicite a incorporação](#4.-heavy_check_mark-Solicite-a-incorporação)
* [Autores](#:pencil2-Autores)


## :books: Documentação da API 
Você pode ter acesso a toda documentação da API clicando <b>[aqui](#)</b>. Nela constam todas as rotas, parâmetros e suas respectivas restrições. 

## :dark_sunglasses: Demonstração da aplicação

Recomendamos o [Postman](https://www.postman.com/) para realização de requisições. Um arquivo inicial com todas as requisições pode ser baixado a seguir.

> [Baixe os arquivos do Postman](https://github.com/ppc-choice/dev.api.ppcchoice.ufes.br/tree/Wellerson-readme-api/postman)

# :ghost: Problemas

Sinta-se à vontade em registrar novos problemas. Caso tenha encontrado a solução, ficaríamos gratos em analisar tal situação. 

Caso encontre algum problema, por favor, faça uma *issue* descrevendo o problema e não se esqueça de incluir as etapas para que possamos reproduzi-lo facilmente.

# :balloon: Contribuição

Agradecemos seu interesse em contribuir!

Caso você tenha alguma ideia para melhorias, sinta-se a vontade em compartilhar por meio de uma *issue*, mas não espere uma resposta em tempo hábil.

Guia e protocolo de contribuição:

#### 1. :pushpin: Pré-requisitos e limitações 

Antes de começar, instale e configure as seguintes ferramentas:
- [PHP]() >= 5.3.7
- [Git](https://git-scm.com/downloads)
- [Servidor Apache](https://httpd.apache.org/download.cgi)
- Editor de texto de sua preferência (recomendado: [VSCode](https://code.visualstudio.com/))
- Ferramenta de requisições HTTP (recomendado: [Postman](https://www.postman.com/))

> **Alerta**: Embora seja recomendado utilizar versões estáveis mais atualizadas da linguagem, é uma imposição do serviço de hospedagem da universidade que a versão do PHP seja 5.3. 

#### 2. :fork_and_knife: Fork este repositório e realize alterações
- Faça um *fork* deste repositório.

- Crie um branch para suas mudanças. Isso separa as mudanças no *pull request* de suas outras mudanças e torna mais fácil editar/corrigir os *commits* no pull request. 
- Edite as alterações e confirme-as localmente.
- Envie-as para o *fork* do GitHub.

  

<!-- Se precisar alterar algo na solicitação pull existente, você pode usar git push -fpara substituir os commits originais. Isso é fácil e seguro ao usar um branch de recursos. -->

<!-- #### 3. :dart: Implemente
- Uma vez finalizada a implementação: -->
  <!-- - Certifique-se de que seu *fork* está atualizado. -->
  <!-- - Crie e verifique o branch em seu *fork*. -->

#### 3. :clipboard: Planeje e execute testes
<!-- Para executar os testes é necessário a instalação do composer. Neste caso, você pode utilizar uma versão mais recente do PHP para criar e atualizar os testes.  -->
Nesta etapa recomenda-se que seus testes sejam escritos e executados utilizando a ferramenta [PHPUnit](https://phpunit.de/) e [GuzzleHttp](http://docs.guzzlephp.org/en/stable/#) . 
Ah! E não se esqueça de documentar ostensivamente seus testes.

Para executar os testes pré-existentes, execute o seguinte comando na raíz do projeto:

```
./vendor/bin/phpunit tests
```
#### 4. :heavy_check_mark: Solicite a incorporação 
<!-- Siga o [procedimento de incorporação de contribuição](#). Ficaremos felizes em avaliar sua contribuição. -->
  - Visite o GitHub e crie uma pull request para solicitar a inclusão de suas alterações no repositório original.
  - Descreva suas alterações de forma clara e sucinta no texto da pull request e marque a *issue* se for o caso.
  - Se mais tarde você precisar adicionar novos *commits* à solicitação pull, você pode simplesmente enviar as alterações para o branch local e usar *git push* para atualizar automaticamente a solicitação *pull*.

# :pencil2: Autores 
<table>
  <tr>
    <td align="center">
      <a href="https://github.com/hadamo">
        <img style="border-radius: 50%;" src="https://avatars2.githubusercontent.com/u/33159326?s=460&u=5a82be8963d06c627b4f59131823d83c70fb3334&v=4" width="100px;" alt=""/>
        <br />
        <sub><b>Hádamo Egito</b>
        </sub>
      </a>
      </br>
        <!-- <div style = "font-size:10px; bottom: -20px;">
            senhorio do badge
         </div> -->
      <a href="https://www.linkedin.com/in/hadamo/">
        <img src="https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/hadamo/"/>
      </a></td>
    <td align="center">
      <a href="https://github.com/Elyabe">
        <img style="border-radius: 50%;" src="https://avatars1.githubusercontent.com/u/27822179?s=460&u=483e56790d8c4e50e0f960205e7abe11a21f3631&v=4" width="100px;" alt=""/>
        <br />
        <sub>
          <b>Elyabe Alves</b>
        </sub>
      </a>
      </br>
      <!-- <div style = "font-size:10px; bottom: -20px;">
            o chefe
      </div> -->
      <a href="https://www.linkedin.com/in/elyabe/">
        <img src="https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/elyabe/"/>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/guilhermegoncalvess"><img style="border-radius: 50%;" src="https://avatars2.githubusercontent.com/u/45895853?s=460&u=b635cebae03921120ecee9fc2d69e1c9f56de2fe&v=4" width="100px;" alt=""/>
        <br />
        <sub>
          <b>Guilherme Gonçalves</b>
        </sub>
      </a>
      </br>
      <!-- <div style = "font-size:10px; bottom: -20px;">
            vamo vava?
         </div> -->
      <a href="https://www.linkedin.com/in/guilhermegoncalvess/">
        <img src="https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/guilhermegoncalvess/"/>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/WellersonPrenholato">
        <img style="border-radius: 50%;" src="https://avatars3.githubusercontent.com/u/18597341?s=460&u=d4a6479fae12995534739952864c145a83431836&v=4" width="100px;" alt=""/>
        <br />
        <sub>
          <b>Wellerson Prenholato</b>
        </sub>
      </a>
      </br>
      <!-- <div style = "font-size:10px; bottom: -20px;">
            commito no master
         </div> -->
      <a href="https://www.linkedin.com/in/wellersonprenholato/">
        <img src="https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/wellersonprenholato/"/>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/GabrielMotaBLima">
        <img style="border-radius: 50%;" src="https://avatars0.githubusercontent.com/u/31813682?s=460&u=0e5d0bed2728e295794155fe59ce9f55d9a13610&v=4" width="100px;" alt=""/>
        <br />
        <sub>
          <b>Gabriel Lima</b>
        </sub>
      </a>
      </br>
         <!-- <div style = "font-size:10px; bottom: -20px;">
            npm install
         </div> -->
         <a href="https://www.linkedin.com/in/gabriel-mota-bromonschenkel-lima-182521140/"> 
            <img src="https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/gabriel-mota-bromonschenkel-lima-182521140/"/>
         </a>
    </td>
  </tr>
</table>

<!-- # :closed_book: Licença -->
