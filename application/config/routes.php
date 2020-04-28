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
$route['instituicoes-ensino-superior/(:num)']['PUT'] = 'InstituicaoEnsinoSuperiorController/update/$1';



// Departamento : Wellerson
$route['departamentos/(:num)']['GET'] = 'DepartamentoController/findById/$1';
$route['departamentos']['GET'] = 'DepartamentoController/findAll';
$route['departamentos']['POST'] = 'DepartamentoController/add';
$route['departamentos/(:num)']['PUT'] = 'DepartamentoController/update/$1';



// Curso : Wellerson
$route['cursos/(:num)']['GET'] = 'CursoController/findById/$1';
$route['cursos']['GET'] = 'CursoController/findAll';
$route['cursos']['POST'] = 'CursoController/add';
$route['cursos/(:num)']['PUT'] = 'CursoController/update/$1';



// Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaController/findAll';
$route['disciplinas/(:num)/(:num)']['GET'] = 'DisciplinaController/findById/$1/$2';
$route['disciplinas']['POST'] = 'DisciplinaController/create';
$route['disciplinas/(:num)/(:num)']['PUT'] = 'DisciplinaController/update/$1/$2';
$route['disciplinas/(:num)/(:num)']['DELETE'] = 'DisciplinaController/delete/$1/$2';



// Unidade de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoController/findAll';
$route['unidades-ensino/(:num)']['GET'] = 'UnidadeEnsinoController/findById/$1';
$route['unidades-ensino']['POST'] = 'UnidadeEnsinoController/create';
$route['unidades-ensino/(:num)']['PUT'] = 'UnidadeEnsinoController/update/$1';
$route['unidades-ensino/(:num)']['DELETE'] = 'UnidadeEnsinoController/delete/$1';



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
$route['componentes-curriculares']['POST'] = 'ComponenteCurricularController/create';
$route['componentes-curriculares/(:num)']['PUT'] = 'ComponenteCurricularController/update/$1';
$route['componentes-curriculares/(:num)']['DELETE'] = 'ComponenteCurricularController/delete/$1';


// Correspondencia : Hadamo
$route['correspondencias']['GET'] = 'CorrespondenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/correspondencias/(:num)']['GET'] = 'CorrespondenciaController/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:num)/correspondencias']['GET'] = 'CorrespondenciaController/findByCodCompCurric/$1';
$route['correspondencias']['POST'] = 'CorrespondenciaController/create';
$route['correspondencias/(:num)/(:num)']['PUT'] = 'CorrespondenciaController/update/$1/$2';
$route['correspondencias/(:num)/(:num)']['DELETE'] = 'CorrespondenciaController/delete/$1/$2';



// Transicao : Hadamo
$route['transicoes']['GET'] = 'TransicaoController/findAll';
$route['unidades-ensino/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodPpc/$1';
$route['transicoes']['POST'] = 'TransicaoController/create';
$route['transicoes/(:num)/(:num)']['PUT'] = 'TransicaoController/update/$1/$2';
$route['transicoes/(:num)/(:num)']['DELETE'] = 'TransicaoController/delete/$1/$2';



// Usuario : Elyabe
$route['usuarios']['GET'] = 'UsuarioController/findAll';
$route['usuarios/(:num)']['GET'] = 'UsuarioController/findById/$1';
$route['usuarios']['POST'] = 'UsuarioController/create';
$route['usuarios/(:num)']['PUT'] = 'UsuarioController/update/$1';
$route['usuarios/(:num)']['DELETE'] = 'UsuarioController/delete/$1';