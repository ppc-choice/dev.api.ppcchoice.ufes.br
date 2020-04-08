define({ "api": [
  {
    "type": "get",
    "url": "dependencias/",
    "title": "Solicitar todas depêndencias existentes entre componentes curriculares.",
    "name": "getAll",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Curso",
            "description": "<p>Nome do curso que a componente curricular pertence.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código identificador de uma componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeCompCurric",
            "description": "<p>Nome da uma componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codPreRequisito",
            "description": "<p>Código identificador de uma componente curricular que é pré-requisito.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomePreReq",
            "description": "<p>Nome do pré-requisito da componente curricular.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"Curso\": \"Ciência da Computação\",\n  \"codCompCurric\": 6,\n  \"nomeCompCurric\": \"Cálculo II\",\n  \"codPreRequisito\": 1\n  \"nomePreReq\": \"Cálculo II\",\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1",
        "type": "curl"
      }
    ],
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaCtl.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/dependencias/"
      }
    ]
  },
  {
    "type": "get",
    "url": "http://dev.api.ppcchoice.ufes.br/dependencias/:codCompCurric/:codPreRequisito",
    "title": "",
    "name": "getById",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Curso",
            "description": "<p>Nome do curso que a componente curricular pertence.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código identificador de uma componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeCompCurric",
            "description": "<p>Nome da uma componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codPreRequisito",
            "description": "<p>Código identificador de uma componente curricular que é pré-requisito.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomePreReq",
            "description": "<p>Nome do pré-requisito da componente curricular.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"Curso\": \"Ciência da Computação\",\n  \"codCompCurric\": 6,\n  \"nomeCompCurric\": \"Cálculo II\",\n  \"codPreRequisito\": 1\n  \"nomePreReq\": \"Cálculo II\",\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1",
        "type": "curl"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  status\": false,\n  \"message\": \"Dependência não encontrado!\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaCtl.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/dependencias/:codCompCurric/:codPreRequisito"
      }
    ]
  },
  {
    "type": "get",
    "url": "http://dev.api.ppcchoice.ufes.br/dependencias/:codPpc",
    "title": "",
    "name": "getByIdPpc",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código identificador de uma componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codPreRequisito",
            "description": "<p>Código identificador de uma componente curricular que é pré-requisito.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n{\n    \"codCompCurric\": 6,\n    \"codPreRequisito\": 1\n}",
          "type": "JSON"
        }
      ]
    },
    "examples": [
      {
        "title": "Exemplo:",
        "content": "curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1/dependencias",
        "type": "curl"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  status\": false,\n  \"message\": \"Dependência não encontrado!\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaCtl.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/dependencias/:codPpc"
      }
    ]
  },
  {
    "type": "get",
    "url": "projetos-pedagogicos-curso/",
    "title": "Solicitar todos Projetos Pedagógicos de Curso.",
    "name": "getAll",
    "group": "Projeto_Pedagógico_Curso",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código de identificação de um Projeto Pedagógico de Curso.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtInicioVigencia",
            "description": "<p>Data correspondente ao ínicio de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtTerminoVigencia",
            "description": "<p>Data correspondente ao término de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalDisciplinaOpt",
            "description": "<p>Carga horária total de disciplinas optativas que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalDisciplinaOb",
            "description": "<p>Carga horária total de disciplinas obrigatórias que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalAtividadeExt",
            "description": "<p>Carga horária total de atividades extra que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalAtividadeCmplt",
            "description": "<p>Carga horária total de atividades complementares que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalProjetoConclusao",
            "description": "<p>Carga horária total de projeto de conclusão de curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalEstagio",
            "description": "<p>Carga horária total de estágio que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "duracao",
            "description": "<p>Tempo de duração do curso descrito por anos.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "qtdPeriodos",
            "description": "<p>Quantidade de períodos necessário para a conclusão do curso em situação normal..</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotal",
            "description": "<p>Carga horária total que as componentes curriculares do curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "anoAprovacao",
            "description": "<p>Ano de aprovação do projeto pedagógico de curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"CORRENTE\"",
              "\"ATIVO ANTERIOR\"",
              "\"INATIVO\""
            ],
            "optional": false,
            "field": "situacao",
            "description": "<p>Situação em que se encontra o projeto pedagógico de curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Código de indentificação do curso que o projeto pedagógico de curso integraliza.  .</p> <p>apiExample {curl} Exemplo: curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HHTP/1.1 200 OK\n{\n    \"codPpc\": 1,\n    \"dtInicioVigencia\": \"2011-08-01\",\n    \"dtTerminoVigencia\": null,\n    \"chTotalDisciplinaOpt\": 240,\n    \"chTotalDisciplinaOb\": 3030,\n    \"chTotalAtividadeExt\": 0,\n    \"chTotalAtividadeCmplt\": 180,\n    \"chTotalProjetoConclusao\": 120,\n    \"chTotalEstagio\": 300,\n    \"duracao\": 5,\n    \"qtdPeriodos\": 10,\n    \"chTotal\": 3870,\n    \"anoAprovacao\": 2011,\n    \"situacao\": \"ATIVO ANTERIOR\",\n    \"codCurso\": 1   \n }",
          "type": "JSON"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoCtl.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/"
      }
    ]
  },
  {
    "type": "get",
    "url": "/projetos-pedagogicos-curso/:codPpc",
    "title": "",
    "name": "getById",
    "group": "Projeto_Pedagógico_Curso",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código de identificação de um Projeto Pedagógico de Curso.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtInicioVigencia",
            "description": "<p>Data correspondente ao ínicio de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "dtTerminoVigencia",
            "description": "<p>Data correspondente ao término de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalDisciplinaOpt",
            "description": "<p>Carga horária total de disciplinas optativas que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalDisciplinaOb",
            "description": "<p>Carga horária total de disciplinas obrigatórias que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalAtividadeExt",
            "description": "<p>Carga horária total de atividades extra que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalAtividadeCmplt",
            "description": "<p>Carga horária total de atividades complementares que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalProjetoConclusao",
            "description": "<p>Carga horária total de projeto de conclusão de curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotalEstagio",
            "description": "<p>Carga horária total de estágio que o curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "duracao",
            "description": "<p>Tempo de duração do curso descrito por anos.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "qtdPeriodos",
            "description": "<p>Quantidade de períodos necessário para a conclusão do curso em situação normal..</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "chTotal",
            "description": "<p>Carga horária total que as componentes curriculares do curso deve possuir.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "anoAprovacao",
            "description": "<p>Ano de aprovação do projeto pedagógico de curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"CORRENTE\"",
              "\"ATIVO ANTERIOR\"",
              "\"INATIVO\""
            ],
            "optional": false,
            "field": "situacao",
            "description": "<p>Situação em que se encontra o projeto pedagógico de curso.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Código de indentificação do curso que o projeto pedagógico de curso integraliza.  .</p> <p>apiExample {curl} Exemplo: curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HHTP/1.1 200 OK\n{\n    \"codPpc\": 1,\n    \"dtInicioVigencia\": \"2011-08-01\",\n    \"dtTerminoVigencia\": null,\n    \"chTotalDisciplinaOpt\": 240,\n    \"chTotalDisciplinaOb\": 3030,\n    \"chTotalAtividadeExt\": 0,\n    \"chTotalAtividadeCmplt\": 180,\n    \"chTotalProjetoConclusao\": 120,\n    \"chTotalEstagio\": 300,\n    \"duracao\": 5,\n    \"qtdPeriodos\": 10,\n    \"chTotal\": 3870,\n    \"anoAprovacao\": 2011,\n    \"situacao\": \"ATIVO ANTERIOR\",\n    \"codCurso\": 1   \n}",
          "type": "JSON"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  status\": false,\n  \"message\": \"Projeto Pedagógico de Curso não encontrado!\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoCtl.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://dev.api.ppcchoice.ufes.br//projetos-pedagogicos-curso/:codPpc"
      }
    ]
  }
] });
