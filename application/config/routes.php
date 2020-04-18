<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Reserved routes - CI
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



// Instituicao de Ensino Superior : Wellerson
$route['instituicoes-ensino-superior/(:num)']['GET'] = 'InstituicaoEnsinoSuperiorController/getById/$1';
$route['instituicoes-ensino-superior']['GET'] = 'InstituicaoEnsinoSuperiorController/getAll';
$route['instituicoes-ensino-superior']['POST'] = 'InstituicaoEnsinoSuperiorController/add';



// Departamento : Wellerson
$route['departamentos/(:num)']['GET'] = 'DepartamentoController/findById/$1';
$route['departamentos']['GET'] = 'DepartamentoController/findAll';
$route['departamentos']['POST'] = 'DepartamentoController/add';



// Curso : Wellerson
$route['cursos/(:num)']['GET'] = 'CursoController/findById/$1';
$route['cursos']['GET'] = 'CursoController/findAll';
$route['cursos']['POST'] = 'CursoController/add';



// Rota para Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaController/findAll';
$route['disciplinas/(:num)/(:num)']['GET'] = 'DisciplinaController/findById/$1/$2';
$route['disciplinas']['POST'] = 'DisciplinaController/add';



// Rota para Unidades de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoController/findAll';
$route['unidades-ensino/(:num)']['GET'] = 'UnidadeEnsinoController/findById/$1';
$route['unidades-ensino']['POST'] = 'UnidadeEnsinoController/add';



// Projeto Pedagógico de Curso : Guilherme
$route['projetos-pedagogicos-curso/(:num)']['GET'] = 'ProjetoPedagogicoCursoController/findById/$1';
$route['projetos-pedagogicos-curso']['GET'] = 'ProjetoPedagogicoCursoController/findAll';
$route['projetos-pedagogicos-curso']['POST'] = 'ProjetoPedagogicoCursoController/add';



// Depêndencia : Guilherme
$route['dependencias/(:num)/(:num)']['GET'] = 'DependenciaController/findById/$1/$2';
$route['dependencias']['GET'] = 'DependenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/dependencias']['GET'] = 'DependenciaController/findByIdPpc/$1';
$route['dependencias']['POST'] = 'DependenciaController/add';


// Componente Curricular : Hadamo
$route['componentes-curriculares']['GET'] = 'ComponenteCurricularController/findAll';
$route['componentes-curriculares/(:num)']['GET'] = 'ComponenteCurricularController/findByCodCompCurric/$1';
$route['projetos-pedagogicos-curso/(:num)/componentes-curriculares']['GET'] = 'ComponenteCurricularController/findByCodPpc/$1';
$route['componentes-curriculares']['POST'] = 'ComponenteCurricularController/add';



// Correspondencia : Hadamo
$route['correspondencias']['GET'] = 'CorrespondenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/correspondencias/(:num)']['GET'] = 'CorrespondenciaController/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:num)/correspondencias']['GET'] = 'CorrespondenciaController/findByCodCompCurric/$1';
$route['correspondencias']['POST'] = 'CorrespondenciaController/add';



// Transicao : Hadamo
$route['transicoes']['GET'] = 'TransicaoController/findAll';
$route['unidades-ensino/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodPpc/$1';
$route['transicoes']['POST'] = 'TransicaoController/add';



// Usuario : Elyabe
$route['usuarios']['GET'] = 'UsuarioController/findAll';
$route['usuarios/(:num)']['GET'] = 'UsuarioController/findById/$1';
$route['usuarios']['POST'] = 'UsuarioController/add';



// Test
$route['migrate']['GET'] = 'Welcome/updateSchema';