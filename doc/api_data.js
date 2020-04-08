define({ "api": [
  {
    "type": "get",
    "url": "cursos/",
    "title": "Apresentar todos Cursos registrados.",
    "name": "getAll",
    "group": "Cursos",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Identificador único do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "anoCriacao",
            "description": "<p>Ano em que o curso foi criado.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unidadeEnsido",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Curso está registrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n \"status\": true,\n \"result\": [\n   {\n     \"codCurso\": 1,\n     \"nomeCurso\": \"Ciência da Computação\",\n     \"anoCriacao\": 2011,\n     \"nomeUnidadeEnsino\": \"Campus São Mateus\",\n     \"nomeIes\": \"Universidade Federal do Espírito Santo\"\n   },\n   {\n     \"codCurso\": 2,\n     \"nomeCurso\": \"Engenharia de Produção\",\n     \"anoCriacao\": 2006,\n     \"nomeUnidadeEnsino\": \"Campus São Mateus\",\n     \"nomeIes\": \"Universidade Federal do Espírito Santo\"\n   },\n   {\n     \"codCurso\": 3,\n     \"nomeCurso\": \"Matemática Industrial\",\n     \"anoCriacao\": 2013,\n     \"nomeUnidadeEnsino\": \"Campus São Mateus\",\n     \"nomeIes\": \"Universidade Federal do Espírito Santo\"\n   }\n ]\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/cursos/",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Nenhum Curso cadastrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Nenhum Curso cadastrado!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/cursos/"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/CursoCtl.php",
    "groupTitle": "Cursos"
  },
  {
    "type": "get",
    "url": "cursos/:codCurso",
    "title": "Apresenta dados de um Curso específico.",
    "name": "getById",
    "group": "Cursos",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Identificador único do Curso requerido.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do Curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "anoCriacao",
            "description": "<p>Ano em que o curso foi criado.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unidadeEnsido",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Curso está registrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"status\": true,\n\t\"result\": {\n\t\"codCurso\": 1,\n\t\"nome\": \"Ciência da Computação\",\n\t\"anoCriacao\": 2011,\n\t\"codUnEnsino\": 1\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/cursos/1",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>O <code>codCurso</code> não corresponde a nenhum Curso cadastrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Curso não encontrado!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/cursos/:codCurso"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/CursoCtl.php",
    "groupTitle": "Cursos"
  },
  {
    "type": "get",
    "url": "departamentos/",
    "title": "Apresentar todos Departamentos registrados.",
    "name": "getAll",
    "group": "Departamentos",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador único da Departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da Departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla da Departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unidadeEnsido",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Departamento está registrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"status\": true,\n\t\"result\": [\n\t{\n\t\t\"codDepto\": 1,\n\t\t\"nome\": \"Departamento de Computação e Eletrônica\",\n\t\t\"abreviatura\": \"DCE\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t},\n\t{\n\t\t\"codDepto\": 2,\n\t\t\"nome\": \"Departamento de Matemática Aplicada\",\n\t\t\"abreviatura\": \"DMA\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t},\n\t{\n\t\t\"codDepto\": 3,\n\t\t\"nome\": \"Departamento de Ciências Naturais\",\n\t\t\"abreviatura\": \"DCN\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t},\n\t{\n\t\t\"codDepto\": 4,\n\t\t\"nome\": \"Departamento de Engenharias  e Tecnologias\",\n\t\t\"abreviatura\": \"DET\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t},\n\t{\n\t\t\"codDepto\": 5,\n\t\t\"nome\": \"Departamento de Educação e Ciências Humanas\",\n\t\t\"abreviatura\": \"ECH\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t},\n\t{\n\t\t\"codDepto\": 6,\n\t\t\"nome\": \"Departamento Não Especificado\",\n\t\t\"abreviatura\": \"DNE\",\n\t\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n\t}\n\t]\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/departamentos/",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Nenhuma Departamento cadastrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Nenhuma Departamento cadastrado!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/departamentos/"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoCtl.php",
    "groupTitle": "Departamentos"
  },
  {
    "type": "get",
    "url": "departamentos/:codDepto",
    "title": "Apresenta dados de um Departamento específico.",
    "name": "getById",
    "group": "Departamentos",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador único do Departamento requerido.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do Departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla do Departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unidadeEnsido",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Departamento está registrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"status\": true,\n\t\"result\": {\n\t\"codDepto\": 1,\n\t\"nome\": \"Departamento de Computação e Eletrônica\",\n\t\"abreviatura\": \"DCE\",\n\t\"nomeUnidadeEnsino\": \"Campus São Mateus\"\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/departamentos/1",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>O <code>codDepto</code> não corresponde a nenhum Departamento cadastrado.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Departamento não encontrado!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/departamentos/:codDepto"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoCtl.php",
    "groupTitle": "Departamentos"
  },
  {
    "type": "get",
    "url": "instituicoes-ensino-superior/",
    "title": "Apresentar todas Instituições de Ensino Superior registradas.",
    "name": "getAll",
    "group": "Instituições_de_Ensino_Superior",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla da Instituição de Ensino Superior.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"status\": true,\n\t\"result\": [\n\t{\n\t\t\"codIes\": 8,\n\t\t\"nome\": \"Harvard\",\n\t\t\"abreviatura\": \"HAR\"\n\t\t},\n\t\t{\n\t\t\"codIes\": 573,\n\t\t\"nome\": \"Universidade Federal do Espírito Santo\",\n\t\t\"abreviatura\": \"UFES\"\n\t\t}\n\t]\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Nenhuma Instituição de Ensino Superior cadastrada.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Instituicao de Ensino Superior não encontrada!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorCtl.php",
    "groupTitle": "Instituições_de_Ensino_Superior"
  },
  {
    "type": "get",
    "url": "instituicoes-ensino-superior/:codIes",
    "title": "Apresentar dados de uma Instituição de Ensino Superior específica.",
    "name": "getById",
    "group": "Instituições_de_Ensino_Superior",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da Instituição de Ensino Superior requerida.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla da Instituição de Ensino Superior.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"status\": true,\n\t\"result\": {\n\t\"codIes\": 573,\n\t\"nome\": \"Universidade Federal do Espírito Santo\",\n\t\"abreviatura\": \"UFES\"\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/573",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>O <code>codIes</code> não corresponde a nenhuma Instituição de Ensino Superior cadastrada.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 OK\n{\n\t\"status\": false,\n\t\"message\": \"Instituicao de Ensino Superior não encontrada!\"\n}",
          "type": "JSON"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/:codIes"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorCtl.php",
    "groupTitle": "Instituições_de_Ensino_Superior"
  },
  {
    "type": "get",
    "url": "usuarios",
    "title": "Solicitar dados de todos os usuários",
    "name": "getAll",
    "group": "Usuario",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codUsuario",
            "description": "<p>Identificador único do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Endereço de e-mail do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "papel",
            "description": "<p>Categoria que define o acesso administrativo do usuário</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "senha",
            "description": "<p>Senha de acesso encriptada.</p>"
          },
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtUltimoAcesso",
            "description": "<p>Data do último acesso realizado pelo usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "conjuntoSelecao",
            "description": "<p>Conjunto de componente curriculares selecionadas pelo usuário.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/usuarios",
        "type": "curl"
      }
    ],
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/usuarios"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoCtl.php",
    "groupTitle": "Usuario"
  },
  {
    "type": "get",
    "url": "usuarios/:id",
    "title": "Solicitar dados de um usuário",
    "name": "getById",
    "group": "Usuario",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identificador único do usuário requerido.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codUsuario",
            "description": "<p>Identificador único do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Endereço de e-mail do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "papel",
            "description": "<p>Categoria que define o acesso administrativo do usuário</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "senha",
            "description": "<p>Senha de acesso encriptada.</p>"
          },
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtUltimoAcesso",
            "description": "<p>Data do último acesso realizado pelo usuário.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "conjuntoSelecao",
            "description": "<p>Conjunto de componente curriculares selecionadas pelo usuário.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n\t\"codUsuario\": 1,\n\t\"senha\": \"$2a$10$W5h77hC63g/0r17QYAmAn.YjnxjZNQHXkWgrhxCNJiFXoebL4Bhra\",\n\t\"nome\": \"Elyabe\",\n\t\"dtUltimoAcesso\": \"2019-01-30\",\n\t\"email\": \"elyabe.santos@ppcchoice\",\n\t\"papel\": \"ADMIN\",\n\t\"conjuntoSelecao\": null\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/usuarios/1",
        "type": "curl"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>O <code>id</code> não corresponde a nenhum usuário cadastrado.</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/usuarios/:id"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoCtl.php",
    "groupTitle": "Usuario"
  }
] });
