define({ "api": [
  {
    "type": "post",
    "url": "componentes-curriculares",
    "title": "Criar Componente Curricular",
    "name": "create",
    "group": "Componente_Curricular",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "periodo",
            "description": "<p>Período da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "credito",
            "description": "<p>Crédito da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "allowedValues": [
              "\"OBRIGATORIA\"",
              "\"OPTATIVA\"",
              "\"ESTAGIO\"",
              "\"ATIVIDADE COMPLEMENTAR\"",
              "\"ATIVIDADE EXTENSAO\"",
              "\"PROJETO CONCLUSAO\""
            ],
            "optional": false,
            "field": "tipo",
            "description": "<p>Tipo da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador único de departamento e parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Número da disicplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ComponenteCurricular: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares"
      }
    ]
  },
  {
    "type": "delete",
    "url": "componentes-curriculares/:codCompCurric",
    "title": "Deletar Componente Curricular",
    "name": "delete",
    "group": "Componente_Curricular",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ComponenteCurricular: Instância deletada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ComponenteCurricular:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares/:codCompCurric"
      }
    ]
  },
  {
    "type": "get",
    "url": "componentes-curriculares",
    "title": "Listar todas as componentes curriculares",
    "name": "findAll",
    "group": "Componente_Curricular",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "ComponenteCurricular[]",
            "optional": false,
            "field": "componentesCurriculares",
            "description": "<p>Array de objetos do tipo ComponenteCurricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "componenteCurricular[nome]",
            "description": "<p>Nome da diciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codCompCurric]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[periodo]",
            "description": "<p>Período da componente.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[credito]",
            "description": "<p>Crédito da componente.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codDepto]",
            "description": "<p>Identificador único de departamento e parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "componenteCurricular[depto]",
            "description": "<p>Abreviatura de departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[numDisciplina]",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codPpc]",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[tipo]",
            "description": "<p>Tipo de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[top]",
            "description": "<p>Posição Vertical da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[left]",
            "description": "<p>Posição Horizontal da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[posicaoColuna]",
            "description": "<p>Posição da componente na coluna da grade curricular.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ComponenteCurricular:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares"
      }
    ]
  },
  {
    "type": "get",
    "url": "componentes-curriculares/:codCompCurric",
    "title": "Solicitar uma componente curricular",
    "name": "findByCodCompCurric",
    "group": "Componente_Curricular",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
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
            "description": "<p>Nome da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "ch",
            "description": "<p>Carga        horária da componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "periodo",
            "description": "<p>Período da componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "credito",
            "description": "<p>Crédito da componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "tipo",
            "description": "<p>Tipo de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador único de departamento e parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "depto",
            "description": "<p>Abreviatura de departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Número da disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "top",
            "description": "<p>Posição Vertical da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "left",
            "description": "<p>Posição Horizontal da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posicaoColuna",
            "description": "<p>Posição da componente na coluna da grade curricular</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ComponenteCurricular:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares/:codCompCurric"
      }
    ]
  },
  {
    "type": "get",
    "url": "projetos-pedagogicos-curso/:codPpc/componentes-curriculares",
    "title": "Listar todas componentes curriculares de um PPC, ordenados por período e componente curricular",
    "name": "findByCodPpc",
    "group": "Componente_Curricular",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Identificador único de projeto pedagógico de curso (PPC).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "ComponenteCurricular[]",
            "optional": false,
            "field": "componentesCurriculares",
            "description": "<p>Array de objetos do tipo ComponenteCurricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "componenteCurricular[nome]",
            "description": "<p>Nome da diciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codCompCurric]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[periodo]",
            "description": "<p>Período da componente.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[credito]",
            "description": "<p>Crédito da componente.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codDepto]",
            "description": "<p>Identificador único de departamento e parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "componenteCurricular[depto]",
            "description": "<p>Abreviatura de departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[numDisciplina]",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[codPpc]",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[tipo]",
            "description": "<p>Tipo de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[top]",
            "description": "<p>Posição Vertical da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[left]",
            "description": "<p>Posição Horizontal da componente na grade curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[posicaoColuna]",
            "description": "<p>Posição da componente na coluna da grade curricular</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ComponenteCurricular:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpc/componentes-curriculares"
      }
    ]
  },
  {
    "type": "get",
    "url": "componentes-curriculares/tipos",
    "title": "Solicitar tipos definidos de componente curricular",
    "name": "findTipos",
    "group": "Componente_Curricular",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "tipos",
            "description": "<p>Array de String com os tipos definidos como constantes.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares/tipos"
      }
    ]
  },
  {
    "type": "put",
    "url": "componentes-curriculares/:codCompCurric",
    "title": "Atualizar Componente Curricular",
    "name": "update",
    "group": "Componente_Curricular",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "periodo",
            "description": "<p>Período da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "credito",
            "description": "<p>Crédito da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "allowedValues": [
              "\"OBRIGATORIA\"",
              "\"OPTATIVA\"",
              "\"ESTAGIO\"",
              "\"ATIVIDADE COMPLEMENTAR\"",
              "\"ATIVIDADE EXTENSAO\"",
              "\"PROJETO CONCLUSAO\""
            ],
            "optional": true,
            "field": "tipo",
            "description": "<p>Tipo da componente.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codDepto",
            "description": "<p>Identificador único de departamento.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "numDisciplina",
            "description": "<p>Número da disciplina, parte do idenficador único de disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codPpc",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ComponenteCurricular: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ComponenteCurricular:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ComponenteCurricularController.php",
    "groupTitle": "Componente_Curricular",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares/:codCompCurric"
      }
    ]
  },
  {
    "type": "post",
    "url": "correspondencias",
    "title": "Criar correspondência",
    "name": "create",
    "group": "Correspondência",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codCompCurricCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "percentual",
            "description": "<p>Percentual de correspondência entre componentes.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Correspondencia: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/correspondencias"
      }
    ]
  },
  {
    "type": "delete",
    "url": "correspondencias/:codCompCurric/:codCompCorresp",
    "title": "Deletar Correspondência",
    "name": "delete",
    "group": "Correspondência",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Correspondencia: Instância deletada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Correspondencia:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/correspondencias/:codCompCurric/:codCompCorresp"
      }
    ]
  },
  {
    "type": "get",
    "url": "correspondencias",
    "title": "Listar todas as correspondências de todas as componentes curriculares.",
    "name": "findAll",
    "group": "Correspondência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Correspondencia[]",
            "optional": false,
            "field": "correspondencia",
            "description": "<p>Array de objetos do tipo Correspondência.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[codCompCurric]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[depto]",
            "description": "<p>Abreviatura de departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[numDisciplina]",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[nomeDisciplina]",
            "description": "<p>Nome de disciplina</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[codCompCurricCorresp]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[deptoDisciplinaCorresp]",
            "description": "<p>Abreviatura de departamento.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[numDisciplinaCorresp]",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[nomeDisciplinaCorresp]",
            "description": "<p>Nome de disciplina</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[percentual]",
            "description": "<p>Percentual de correspondência entre componentes.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Correspondencia:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/correspondencias"
      }
    ]
  },
  {
    "type": "get",
    "url": "projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo",
    "title": "Listar todas as relações de correspondência entre os cursos referidos",
    "name": "findAllByCodPpc",
    "group": "Correspondência",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Identificador único do ppc atual.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAlvo",
            "description": "<p>Identificador único do ppc alvo.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Correspondencia[]",
            "optional": false,
            "field": "correspondencia",
            "description": "<p>Array de objetos do tipo Correspondência.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[codCompCurric]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[nomeDisciplina]",
            "description": "<p>Nome de disciplina</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "correspondencia[nomeDisciplinaCorresp]",
            "description": "<p>Nome de disciplina</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[tipoCompCurric]",
            "description": "<p>Tipo de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[tipoCompCurricCorresp]",
            "description": "<p>Tipo de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[chDisciplina]",
            "description": "<p>Carga Horária de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "componenteCurricular[chDisciplinaCorresp]",
            "description": "<p>Carga Horária de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[codCompCorresp]",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "correspondencia[percentual]",
            "description": "<p>Percentual de correspondência entre componentes.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Correspondencia:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo"
      }
    ]
  },
  {
    "type": "get",
    "url": "componentes-curriculares/:codCompCurric/correspondencias/:codCompCorresp",
    "title": "Listar as correspondências de uma componente curricular",
    "name": "findByCodCompCurric",
    "group": "Correspondência",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
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
            "field": "nomeDisciplina",
            "description": "<p>Nome de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeDisciplinaCorresp",
            "description": "<p>Nome de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codCompCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "numDisciplinaCorresp",
            "description": "<p>Número de disciplina, parte do identificador único de disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "percentual",
            "description": "<p>Percentual de correspondência entre componentes.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Correspondencia:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/componentes-curriculares/:codCompCurric/correspondencias/:codCompCorresp"
      }
    ]
  },
  {
    "type": "put",
    "url": "correspondencia/:codCompCurric/:codCompCorresp",
    "title": "Atualizar Correspondência",
    "name": "update",
    "group": "Correspondência",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCompCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codCompCurric",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codCompCurricCorresp",
            "description": "<p>Identificador único de componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "percentual",
            "description": "<p>Percentual de correspondência entre componentes.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Correspondencia: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Correspondencia:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CorrespondenciaController.php",
    "groupTitle": "Correspondência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/correspondencia/:codCompCurric/:codCompCorresp"
      }
    ]
  },
  {
    "type": "post",
    "url": "cursos",
    "title": "Criar um Curso.",
    "name": "create",
    "group": "Curso",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do Curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "size": "1950-2020",
            "optional": false,
            "field": "anoCriacao",
            "description": "<p>Ano em que o curso foi criado.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Curso está registrado.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Curso: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CursoController.php",
    "groupTitle": "Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos"
      }
    ]
  },
  {
    "type": "delete",
    "url": "cursos/:codCurso",
    "title": "Excluir um Curso.",
    "name": "delete",
    "group": "Curso",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Identificador único do Curso.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Curso: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Curso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CursoController.php",
    "groupTitle": "Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos/:codCurso"
      }
    ]
  },
  {
    "type": "get",
    "url": "cursos",
    "title": "Solicitar todos Cursos registrados.",
    "name": "findAll",
    "group": "Curso",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Curso[]",
            "optional": false,
            "field": "curso",
            "description": "<p>Array de objetos do tipo Curso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Curso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CursoController.php",
    "groupTitle": "Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos"
      }
    ]
  },
  {
    "type": "get",
    "url": "cursos/:codCurso",
    "title": "Solicitar dados de um Curso.",
    "name": "findById",
    "group": "Curso",
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
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Curso está registrado.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeUnidadeEnsino",
            "description": "<p>Nome da Unidade de Ensino na qual o Curso está registrado.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeIes",
            "description": "<p>Nome da Instituição de Ensino Superior na qual o Curso está registrado.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Curso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CursoController.php",
    "groupTitle": "Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos/:codCurso"
      }
    ]
  },
  {
    "type": "put",
    "url": "cursos/:codCurso",
    "title": "Atualizar dados de um Curso.",
    "name": "update",
    "group": "Curso",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
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
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome do Curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "size": "1950-2020",
            "optional": true,
            "field": "anoCriacao",
            "description": "<p>Ano em que o curso foi criado.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Curso está registrado.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Curso: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Curso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/CursoController.php",
    "groupTitle": "Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos/:codCurso"
      }
    ]
  },
  {
    "type": "post",
    "url": "departamentos",
    "title": "Criar um Departamento.",
    "name": "create",
    "group": "Departamento",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do Departamento.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "size": "3..5",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla do Departamento.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Departamento: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoController.php",
    "groupTitle": "Departamento",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/departamentos"
      }
    ]
  },
  {
    "type": "delete",
    "url": "departamentos/:codDepto",
    "title": "Excluir um Departamento.",
    "name": "delete",
    "group": "Departamento",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador único do Departamento.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Departamento: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Departamento: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoController.php",
    "groupTitle": "Departamento",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/departamentos/:codDepto"
      }
    ]
  },
  {
    "type": "get",
    "url": "departamentos",
    "title": "Solicitar dados de todos Departamentos.",
    "name": "findAll",
    "group": "Departamento",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Departamento[]",
            "optional": false,
            "field": "departamento",
            "description": "<p>Array de objetos do tipo Departamento.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Departamento: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoController.php",
    "groupTitle": "Departamento",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/departamentos"
      }
    ]
  },
  {
    "type": "get",
    "url": "departamentos/:codDepto",
    "title": "Solicitar dados de um Departamento específico.",
    "name": "findById",
    "group": "Departamento",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
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
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino na qual o Departamento está registrado.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeUnidadeEnsino",
            "description": "<p>Nome da Unidade de Ensino na qual o Departamento está registrado.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeIes",
            "description": "<p>Nome da Instituição de Ensino Superior na qual o Departamento está registrado.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Departamento: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoController.php",
    "groupTitle": "Departamento",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/departamentos/:codDepto"
      }
    ]
  },
  {
    "type": "put",
    "url": "departamentos/:codDepto",
    "title": "Atualizar dados de um Departamento.",
    "name": "update",
    "group": "Departamento",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
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
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome do Departamento.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "size": "3..5",
            "optional": true,
            "field": "abreviatura",
            "description": "<p>Sigla do Departamento.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único da Unidade de Ensino.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Departamento: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Departamento: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DepartamentoController.php",
    "groupTitle": "Departamento",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/departamentos/:codDepto"
      }
    ]
  },
  {
    "type": "POST",
    "url": "dependencias",
    "title": "Criar uma nova dependência entre componentes curriculares.",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código identificador de uma componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codPreRequisito",
            "description": "<p>Código identificador de uma componente curricular que é pré-requisito.</p>"
          }
        ]
      }
    },
    "name": "create",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Dependencia: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/dependencias"
      }
    ]
  },
  {
    "type": "DELETE",
    "url": "dependencias/:codCompCurric/:codPreReq",
    "title": "Deletar dependência entre componentes curriculares.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código de identificação de uma componente curricular.</p>"
          },
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPreReq",
            "description": "<p>Código de identificação de uma componente curricular que é pré-requisito.</p>"
          }
        ]
      }
    },
    "name": "delete",
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
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Dependencia: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/dependencias/:codCompCurric/:codPreReq"
      }
    ]
  },
  {
    "type": "GET",
    "url": "dependencias",
    "title": "Solicitar todas dependências existentes entre componentes curriculares.",
    "name": "findAll",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Dependencia[]",
            "optional": false,
            "field": "dependencia",
            "description": "<p>Array de objetos do tipo depenência.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/dependencias"
      }
    ]
  },
  {
    "type": "GET",
    "url": "projetos-pedagogicos-curso/:codPpc/dependencias",
    "title": "Solicitar todas dependências entre componentes as curriculares de um Projeto Pedagógico de Curso.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código identificador de um projeto pedagógico de curso.</p>"
          },
          {
            "group": "URL",
            "type": "bool",
            "optional": false,
            "field": "allowEmpty",
            "description": "<p>Parâmetro que informa se o método deve retornar um array de Depêndencias vazio.</p>"
          },
          {
            "group": "URL",
            "type": "bool",
            "optional": false,
            "field": "senseConnection",
            "description": "<p>Parâmetro que informa se o método deve retornar uma string de sentido da dependencia concatenada ao seu respectivo código.</p>"
          }
        ]
      }
    },
    "name": "findByCodPpc",
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
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpc/dependencias"
      }
    ]
  },
  {
    "type": "GET",
    "url": "dependencias/:codCompCurric/:codPreReq",
    "title": "Solicitar dependências entre componentes curriculares.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código de identificação de uma componente curricular.</p>"
          },
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPreReq",
            "description": "<p>Código de identificação de uma componente curricular que é pré-requisito.</p>"
          }
        ]
      }
    },
    "name": "findById",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeCurso",
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
            "description": "<p>Nome da componente curricular.</p>"
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
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/dependencias/:codCompCurric/:codPreReq"
      }
    ]
  },
  {
    "type": "PUT",
    "url": "dependencias/:codCompCurric/:codPreReq",
    "title": "Atualizar depêndencia entre componentes curriculares.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codCompCurric",
            "description": "<p>Código de identificação de uma componente curricular.</p>"
          },
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPreReq",
            "description": "<p>Código de identificação de uma componente curricular que é pré-requisito.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codCompCurric",
            "description": "<p>Código identificador de uma componente curricular.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codPreRequisito",
            "description": "<p>Código identificador de uma componente curricular que é pré-requisito.</p>"
          }
        ]
      }
    },
    "name": "update",
    "group": "Dependência",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Dependencia: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Dependencia: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DependenciaController.php",
    "groupTitle": "Dependência",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/dependencias/:codCompCurric/:codPreReq"
      }
    ]
  },
  {
    "type": "post",
    "url": "disciplinas",
    "title": "Criar uma disciplina",
    "name": "create",
    "group": "Disciplina",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Identificador primário da disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "ch",
            "description": "<p>Carga horária da disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Identificador secundário da disciplina (identificador primário do departamento que ela está vinculada).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Disciplina: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DisciplinaController.php",
    "groupTitle": "Disciplina",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/disciplinas"
      }
    ]
  },
  {
    "type": "delete",
    "url": "disciplinas/:codDepto/:numDisciplina",
    "title": "Excluir uma disciplina",
    "name": "delete",
    "group": "Disciplina",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Identificador único da disciplina.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Código do departamento cujo qual a disciplina está vinculada.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Disciplina: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Disciplina: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DisciplinaController.php",
    "groupTitle": "Disciplina",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/disciplinas/:codDepto/:numDisciplina"
      }
    ]
  },
  {
    "type": "get",
    "url": "disciplinas",
    "title": "Solicitar dados de todas as disciplinas",
    "name": "findAll",
    "group": "Disciplina",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Disciplina[]",
            "optional": false,
            "field": "disciplina",
            "description": "<p>Array de objetos do tipo Disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "disciplina[numDisciplina]",
            "description": "<p>Identificador único da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "disciplina[nome]",
            "description": "<p>Nome da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "disciplina[ch]",
            "description": "<p>Carga horária da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "disciplina[codDepto]",
            "description": "<p>Código do departamento cujo qual a disciplina está vinculada.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "disciplina[abreviaturaDepto]",
            "description": "<p>Abreviatura do departamento cujo qual a disciplina está vinculada.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Disciplina: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DisciplinaController.php",
    "groupTitle": "Disciplina",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/disciplinas"
      }
    ]
  },
  {
    "type": "get",
    "url": "disciplinas/:codDepto/:numDisciplina",
    "title": "Solicitar dados de uma disciplina",
    "name": "findById",
    "group": "Disciplina",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Identificador único da disciplina.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Código do departamento cujo qual a disciplina está vinculada.</p>"
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
            "description": "<p>Nome da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "ch",
            "description": "<p>Carga horária da disciplina.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nomeDepto",
            "description": "<p>Nome do departamento cujo qual a disciplina está vinculada.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Disciplina: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DisciplinaController.php",
    "groupTitle": "Disciplina",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/disciplinas/:codDepto/:numDisciplina"
      }
    ]
  },
  {
    "type": "put",
    "url": "disciplinas/:codDepto/:numDisciplina",
    "title": "Atualizar dados de uma disciplina",
    "name": "update",
    "group": "Disciplina",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "numDisciplina",
            "description": "<p>Identificador único de uma disciplina.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codDepto",
            "description": "<p>Código do departamento cujo qual a disciplina está vinculada.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome da disciplina.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "ch",
            "description": "<p>Carga horária da disciplina.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Disciplina: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Disciplina: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/DisciplinaController.php",
    "groupTitle": "Disciplina",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/disciplinas/:codDepto/:numDisciplina"
      }
    ]
  },
  {
    "type": "post",
    "url": "instituicoes-ensino-superior",
    "title": "Criar uma Instituição de Ensino Superior.",
    "name": "create",
    "group": "Instituição_de_Ensino_Superior",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "abreviatura",
            "description": "<p>Sigla da Instituição de Ensino Superior.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorController.php",
    "groupTitle": "Instituição_de_Ensino_Superior",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/instituicoes-ensino-superior"
      }
    ]
  },
  {
    "type": "delete",
    "url": "instituicoes-ensino-superior/:codIes",
    "title": "Excluir uma Instituição de Ensino Superior.",
    "name": "delete",
    "group": "Instituição_de_Ensino_Superior",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da Instituição de Ensino Superior.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorController.php",
    "groupTitle": "Instituição_de_Ensino_Superior",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/instituicoes-ensino-superior/:codIes"
      }
    ]
  },
  {
    "type": "get",
    "url": "instituicoes-ensino-superior",
    "title": "Solicitar dados de todas Instituições de Ensino Superior.",
    "name": "findAll",
    "group": "Instituição_de_Ensino_Superior",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "InstituicaoEnsinoSuperior[]",
            "optional": false,
            "field": "InstituicaoEnsinoSuperior",
            "description": "<p>Array de objetos do tipo InstituicaoEnsinoSuperior.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorController.php",
    "groupTitle": "Instituição_de_Ensino_Superior",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/instituicoes-ensino-superior"
      }
    ]
  },
  {
    "type": "get",
    "url": "instituicoes-ensino-superior/:codIes",
    "title": "Solicitar dados de uma Instituição de Ensino Superior.",
    "name": "findById",
    "group": "Instituição_de_Ensino_Superior",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
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
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorController.php",
    "groupTitle": "Instituição_de_Ensino_Superior",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/instituicoes-ensino-superior/:codIes"
      }
    ]
  },
  {
    "type": "put",
    "url": "instituicoes-ensino-superior/:codIes",
    "title": "Atualizar dados de uma Instituição de Ensino Superior.",
    "name": "update",
    "group": "Instituição_de_Ensino_Superior",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da Instituição de Ensino Superior.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome da Instituição de Ensino Superior.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "abreviatura",
            "description": "<p>Sigla da Instituição de Ensino Superior.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/InstituicaoEnsinoSuperiorController.php",
    "groupTitle": "Instituição_de_Ensino_Superior",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/instituicoes-ensino-superior/:codIes"
      }
    ]
  },
  {
    "type": "post",
    "url": "projetos-pedagogicos-curso",
    "title": "Criar um novo Projeto Pedagógico de Curso.",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "DateTime",
            "optional": false,
            "field": "dtInicioVigencia",
            "description": "<p>Data correspondente ao ínicio de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "DateTime",
            "optional": false,
            "field": "dtTerminoVigencia",
            "description": "<p>Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS).</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalDisciplinaOpt",
            "defaultValue": "0",
            "description": "<p>Carga horária total de disciplinas optativas que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalDisciplinaOb",
            "defaultValue": "0",
            "description": "<p>Carga horária total de disciplinas obrigatórias que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalAtividadeExt",
            "defaultValue": "0",
            "description": "<p>Carga horária total de atividades extensão que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalAtividadeCmplt",
            "defaultValue": "0",
            "description": "<p>Carga horária total de atividades complementares que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalProjetoConclusao",
            "defaultValue": "0",
            "description": "<p>Carga horária total de projeto de conclusão de curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalEstagio",
            "defaultValue": "0",
            "description": "<p>Carga horária total de estágio que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "qtdPeriodos",
            "description": "<p>Quantidade de períodos necessário para a conclusão do curso em situação normal.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "anoAprovacao",
            "description": "<p>Ano de aprovação do projeto pedagógico de curso.</p>"
          },
          {
            "group": "Request Body/JSON",
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
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Código de indentificação do curso que o projeto pedagógico de curso integraliza.</p>"
          }
        ]
      }
    },
    "name": "create",
    "group": "Projeto_Pedagógico_Curso",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso"
      }
    ]
  },
  {
    "type": "DELETE",
    "url": "projetos-pedagogicos-curso/:codPpc",
    "title": "Deletar Projeto Pedagógico de Curso.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código de identificação de um Projeto Pedagógico de Curso.</p>"
          }
        ]
      }
    },
    "name": "delete",
    "group": "Projeto_Pedagógico_Curso",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpc"
      }
    ]
  },
  {
    "type": "GET",
    "url": "projetos-pedagogicos-curso",
    "title": "Solicitar todos Projetos Pedagógicos de Curso.",
    "name": "findAll",
    "group": "Projeto_Pedagógico_Curso",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "ProjetoPedagogicoCurso[]",
            "optional": false,
            "field": "projetoPedag",
            "description": "<p>ógicoCurso Array de objetos do tipo Projeto Pesagógico Curso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso"
      }
    ]
  },
  {
    "type": "get",
    "url": "cursos/:codCurso/projetos-pedagogicos-curso",
    "title": "Requisitar todos Projetos Pedagógicos de Curso de um Curso.",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Código de identificação de um Curso.</p>"
          }
        ]
      }
    },
    "name": "findByCodCurso",
    "group": "Projeto_Pedagógico_Curso",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "ProjetoPedagogicoCurso[]",
            "optional": false,
            "field": "Projeto",
            "description": "<p>Pedagógico Curso Array de objetos do tipo Projeto Pedagógico Curso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/cursos/:codCurso/projetos-pedagogicos-curso"
      }
    ]
  },
  {
    "type": "GET",
    "url": "projetos-pedagogicos-curso/:codPpc",
    "title": "Solicitar Projeto Pedagógico de Curso.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código de identificação de um Projeto Pedagógico de Curso.</p>"
          }
        ]
      }
    },
    "name": "findById",
    "group": "Projeto_Pedagógico_Curso",
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
            "description": "<p>Carga horária total de atividades extensão que o curso deve possuir.</p>"
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
            "description": "<p>Quantidade de períodos necessário para a conclusão do curso em situação normal.</p>"
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
            "type": "Number",
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
            "type": "Number",
            "optional": false,
            "field": "codCurso",
            "description": "<p>Código de indentificação do curso que o projeto pedagógico de curso integraliza.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpc"
      }
    ]
  },
  {
    "type": "PUT",
    "url": "projetos-pedagogicos-curso/:codPpc",
    "title": "Atualizar um Projeto Pedagógico de Curso.",
    "parameter": {
      "fields": {
        "URL": [
          {
            "group": "URL",
            "type": "Number",
            "optional": false,
            "field": "codPpc",
            "description": "<p>Código de identificação de um Projeto Pedagógico de Curso.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "DateTime",
            "optional": true,
            "field": "dtInicioVigencia",
            "description": "<p>Data correspondente ao ínicio de vigência do projeto pedagógico do curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "DateTime",
            "optional": true,
            "field": "dtTerminoVigencia",
            "description": "<p>Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS).</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalDisciplinaOpt",
            "description": "<p>Carga horária total de disciplinas optativas que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalDisciplinaOb",
            "description": "<p>Carga horária total de disciplinas obrigatórias que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalAtividadeExt",
            "description": "<p>Carga horária total de atividades extensão que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalAtividadeCmplt",
            "description": "<p>Carga horária total de atividades complementares que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalProjetoConclusao",
            "description": "<p>Carga horária total de projeto de conclusão de curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "chTotalEstagio",
            "description": "<p>Carga horária total de estágio que o curso deve possuir.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "qtdPeriodos",
            "description": "<p>Quantidade de períodos necessário para a conclusão do curso em situação normal.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "anoAprovacao",
            "description": "<p>Ano de aprovação do projeto pedagógico de curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "allowedValues": [
              "\"CORRENTE\"",
              "\"ATIVO ANTERIOR\"",
              "\"INATIVO\""
            ],
            "optional": true,
            "field": "situacao",
            "description": "<p>Situação em que se encontra o projeto pedagógico de curso.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codCurso",
            "description": "<p>Código de indentificação do curso que o projeto pedagógico de curso integraliza.</p>"
          }
        ]
      }
    },
    "name": "update",
    "group": "Projeto_Pedagógico_Curso",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\ProjetoPedagogicoCurso: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/ProjetoPedagogicoCursoController.php",
    "groupTitle": "Projeto_Pedagógico_Curso",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpc"
      }
    ]
  },
  {
    "type": "post",
    "url": "transicoes",
    "title": "Criar transição",
    "name": "create",
    "group": "Transição",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codPpcAlvo",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Transicao: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/transicoes"
      }
    ]
  },
  {
    "type": "delete",
    "url": "transicoes/:codPpcAtual/:codPpcAlvo",
    "title": "Deletar Componente Curricular",
    "name": "delete",
    "group": "Transição",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAlvo",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Transicao: Instância deletada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Transicao:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/transicoes/:codPpcAtual/:codPpcAlvo"
      }
    ]
  },
  {
    "type": "get",
    "url": "transicoes",
    "title": "Listar todas as transições.",
    "name": "findAll",
    "group": "Transição",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Transicao[]",
            "optional": false,
            "field": "transicao",
            "description": "<p>Array de objetos do tipo transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "transicao[ppcAtual]",
            "description": "<p>Nome do curso e ano de aprovação do ppc atual.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "transicao[codPpcAtual]",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "transicao[ppcAlvo]",
            "description": "<p>Nome do curso e ano de aprovação do ppc alvo.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "transicao[codPpcAlvo]",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Transicao:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/transicoes"
      }
    ]
  },
  {
    "type": "get",
    "url": "projetos-pedagogicos-curso/:codPpcAtual/transicoes",
    "title": "Listar as transições mapeadas de um ppc.",
    "name": "findByCodPpc",
    "group": "Transição",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Transicao[]",
            "optional": false,
            "field": "transicao",
            "description": "<p>Array de objetos do tipo transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "transicao[ppcAtual]",
            "description": "<p>Nome do curso e Ano de aprovação do ppc atual da transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "transicao[ppcAlvo]",
            "description": "<p>Nome do curso e Ano de aprovação do ppc alvo da transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "transicao[codPpcAtual]",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "transicao[codPpcAlvo]",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Transicao:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/projetos-pedagogicos-curso/:codPpcAtual/transicoes"
      }
    ]
  },
  {
    "type": "get",
    "url": "unidades-ensino/:codUnidadeEnsino/transicoes",
    "title": "Listar os cursos atuais da unidade de ensino especificada para os quais há transição.",
    "name": "findByCodUnidadeEnsino",
    "group": "Transição",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único de unidade de ensino.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Transicao[]",
            "optional": false,
            "field": "transicao",
            "description": "<p>Array de objetos do tipo transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "transicao[nomeCurso]",
            "description": "<p>Nome do curso e Ano de aprovação do ppc atual da transição.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "transicao[codPpc]",
            "description": "<p>Identificador único de ppc</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Transicao:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino/:codUnidadeEnsino/transicoes"
      }
    ]
  },
  {
    "type": "put",
    "url": "transicao/:codPpcAtual/:codPpcAlvo",
    "title": "Atualizar transição",
    "name": "update",
    "group": "Transição",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codPpcAlvo",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codPpcAtual",
            "description": "<p>Identificador único de ppc.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": true,
            "field": "codPpcAlvo",
            "description": "<p>Identificador único de ppc.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Transicao: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Transicao:    Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/TransicaoController.php",
    "groupTitle": "Transição",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/transicao/:codPpcAtual/:codPpcAlvo"
      }
    ]
  },
  {
    "type": "post",
    "url": "unidades-ensino",
    "title": "Criar uma unidade de ensino",
    "name": "create",
    "group": "Unidade_de_Ensino",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da unidade de ensino.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "cnpj",
            "description": "<p>CNPJ da unidade de ensino.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da instutuição de ensino que a unidade de ensino está vinculada.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\UnidadeEnsino: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoController.php",
    "groupTitle": "Unidade_de_Ensino",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino"
      }
    ]
  },
  {
    "type": "delete",
    "url": "unidades-ensino/:codUnidadeEnsino",
    "title": "Excluir uma unidade de ensino",
    "name": "delete",
    "group": "Unidade_de_Ensino",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Identificador único de uma unidade de ensino.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\UnidadeEnsino: Instância removida com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\UnidadeEnsino: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoController.php",
    "groupTitle": "Unidade_de_Ensino",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino/:codUnidadeEnsino"
      }
    ]
  },
  {
    "type": "get",
    "url": "unidades-ensino",
    "title": "Solicitar dados de todas as unidades de ensino",
    "name": "findAll",
    "group": "Unidade_de_Ensino",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "UnidadeEnsino[]",
            "optional": false,
            "field": "unidadeEnsino",
            "description": "<p>Array de objetos do tipo Unidade de Ensino.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "unidadeEnsino[codUnidadeEnsino]",
            "description": "<p>Identificador único da unidade de ensino.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "unidadeEnsino[nome]",
            "description": "<p>Nome da instituição de ensino cuja qual a unidade de ensino está vinculada.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\UnidadeEnsino: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoController.php",
    "groupTitle": "Unidade_de_Ensino",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino"
      }
    ]
  },
  {
    "type": "get",
    "url": "unidades-ensino/:codUnidadeEnsino",
    "title": "Solicitar dados de uma unidade de ensino",
    "name": "findById",
    "group": "Unidade_de_Ensino",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Codigo unico de uma unidade de ensino.</p>"
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
            "field": "nomeIes",
            "description": "<p>Nome da instituição de ensino que a unidade de ensino está vinculada.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "abreviaturaIes",
            "description": "<p>Abreviatura da instituição de ensino vinculada à unidade de ensino.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "codIes",
            "description": "<p>Identificador único da instutuição de ensino que a unidade de ensino está vinculada.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome da unidade de ensino.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "cnpj",
            "description": "<p>CNPJ da unidade de ensino.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\UnidadeEnsino: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoController.php",
    "groupTitle": "Unidade_de_Ensino",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino/:codUnidadeEnsino"
      }
    ]
  },
  {
    "type": "put",
    "url": "unidades-ensino/:codUnidadeEnsino",
    "title": "Atualizar dados de uma unidade de ensino",
    "name": "update",
    "group": "Unidade_de_Ensino",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Codigo único de uma unidade de ensino.</p>"
          }
        ],
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome da unidade de ensino.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "cnpj",
            "description": "<p>CNPJ da unidade de esnino.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "codIes",
            "description": "<p>Identificador único da instituição de ensino que a unidade de ensino está vinculada.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\UnidadeEnsino: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\UnidadeEnsino: Instância não encontrada.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UnidadeEnsinoController.php",
    "groupTitle": "Unidade_de_Ensino",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/unidades-ensino/:codUnidadeEnsino"
      }
    ]
  },
  {
    "type": "post",
    "url": "usuarios",
    "title": "Criar um usuário",
    "name": "create",
    "group": "Usuário",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Endereço de e-mail do usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "allowedValues": [
              "ADMINISTRATOR",
              "SUPERVISOR",
              "VISITOR"
            ],
            "optional": true,
            "field": "papel",
            "defaultValue": "VISITOR",
            "description": "<p>Categoria que define o acesso administrativo do usuário</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "senha",
            "description": "<p>Senha de acesso encriptada.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "JSON",
            "optional": true,
            "field": "conjuntoSelecao",
            "description": "<p>Conjunto de componente curriculares selecionadas pelo usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAtual]",
            "description": "<p>Identificador único do PPC atual.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAlvo]",
            "description": "<p>Identificador único do PPC alvo.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number[]",
            "optional": false,
            "field": "conjuntoSelecao[componentesCurriculares]",
            "description": "<p>Conjunto de identificadores únicos das componentes curriculares selecionadas.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Usuario: Instância criada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "400",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios"
      }
    ]
  },
  {
    "type": "delete",
    "url": "usuarios/:codUsuario",
    "title": "Excluir um usuário",
    "name": "delete",
    "group": "Usuário",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUsuario",
            "description": "<p>Identificador único do usuário.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Usuario: Instância deletada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "404",
            "description": "<p>O <code>codUsuario</code> não corresponde a um usuário cadastrado.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios/:codUsuario"
      }
    ]
  },
  {
    "type": "get",
    "url": "usuarios",
    "title": "Solicitar dados da coleção dos usuários",
    "name": "findAll",
    "group": "Usuário",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Usuario[]",
            "optional": false,
            "field": "usuarios",
            "description": "<p>Array de objetos do tipo usuário.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Entities\\Usuario: Instância não encontrada. Não existem usuários cadastrados</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios"
      }
    ]
  },
  {
    "type": "get",
    "url": "usuarios/:codUsuario",
    "title": "Solicitar dados de um usuário",
    "name": "findById",
    "group": "Usuário",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "codUsuario",
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
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAtual]",
            "description": "<p>Identificador único do PPC atual.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAlvo]",
            "description": "<p>Identificador único do PPC alvo.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number[]",
            "optional": false,
            "field": "conjuntoSelecao[componentesCurriculares]",
            "description": "<p>Conjunto de identificadores únicos das componentes curriculares selecionadas.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "404",
            "description": "<p>O <code>codUsuario</code> não corresponde a um usuário cadastrado.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios/:codUsuario"
      }
    ]
  },
  {
    "type": "post",
    "url": "usuarios/login",
    "title": "Entrar na conta de usuário",
    "name": "login",
    "group": "Usuário",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "email",
            "description": "<p>Endereço de e-mail do usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "senha",
            "description": "<p>Senha de acesso.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "usuario",
            "description": "<p>Perfil do usuário logado</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "usuario[email]",
            "description": "<p>Endereço de email do usuário</p>"
          },
          {
            "group": "Success 200",
            "type": "DateTime",
            "optional": false,
            "field": "usuario[dtUltimoAcesso]",
            "description": "<p>Data e hora do último login realizado com sucesso</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "usuario[papel]",
            "description": "<p>Categoria que define o nível de acesso</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "usuario[nome]",
            "description": "<p>Nome do usuário</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token de acesso JWT</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "401",
            "description": "<p>Entities\\Usuario.(email|senha): Credencial inválida. O <code>email</code> ou <code>senha</code> informado(s) não são válidos</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios/login"
      }
    ]
  },
  {
    "type": "put",
    "url": "usuarios/:codUsuario",
    "title": "Atualizar dados de um usuário",
    "name": "update",
    "group": "Usuário",
    "permission": [
      {
        "name": "ADMINISTRATOR"
      }
    ],
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "email",
            "description": "<p>Endereço de e-mail do usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "nome",
            "description": "<p>Nome do usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "papel",
            "description": "<p>Categoria que define o acesso administrativo do usuário</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": true,
            "field": "senha",
            "description": "<p>Senha de acesso encriptada.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "DateTime",
            "optional": true,
            "field": "dtUltimoAcesso",
            "description": "<p>Data do último acesso realizado pelo usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "JSON",
            "optional": true,
            "field": "conjuntoSelecao",
            "description": "<p>Conjunto de componente curriculares selecionadas pelo usuário.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAtual]",
            "description": "<p>Identificador único do PPC atual.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number",
            "optional": false,
            "field": "conjuntoSelecao[ppcAlvo]",
            "description": "<p>Identificador único do PPC alvo.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "Number[]",
            "optional": false,
            "field": "conjuntoSelecao[componentesCurriculares]",
            "description": "<p>Conjunto de identificadores únicos das componentes curriculares selecionadas.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Entities\\Usuario: Instância atualizada com sucesso.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "404",
            "description": "<p>O <code>codUsuario</code> não corresponde a um usuário cadastrado.</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "400",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/UsuarioController.php",
    "groupTitle": "Usuário",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/usuarios/:codUsuario"
      }
    ]
  },
  {
    "type": "post",
    "url": "verificacao-upload",
    "title": "Verificar a autenticidade do arquivo JSON",
    "name": "create",
    "group": "Verification_Upload",
    "parameter": {
      "fields": {
        "Request Body/JSON": [
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "codUnidadeEnsino",
            "description": "<p>Código de identificação da Unidade de Ensino.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String",
            "optional": false,
            "field": "codPpcAtual",
            "description": "<p>Código de identificação do Projeto Pedagógico do Curso atual.</p>"
          },
          {
            "group": "Request Body/JSON",
            "type": "String[]",
            "optional": false,
            "field": "conjuntoSelecao[componentesCurriculares]",
            "description": "<p>Conjunto de identificadores únicos das componentes curriculares selecionadas.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": false,
            "field": "message",
            "description": "<p>Verificação feita com sucesso!.</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String[]",
            "optional": false,
            "field": "error",
            "description": "<p>Campo obrigatório não informado ou contém valor inválido.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "application/controllers/VerificacaoArquivoUploadController.php",
    "groupTitle": "Verification_Upload",
    "sampleRequest": [
      {
        "url": "http://ppcchoice.ufes.br/api/verificacao-upload"
      }
    ]
  }
] });
