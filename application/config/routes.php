<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Reserved routes - CI
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



// Instituicao de Ensino Superior : Wellerson
$route['instituicoes-ensino-superior/(:num)']['GET'] = 'InstituicaoEnsinoSuperiorController/findById/$1';
$route['instituicoes-ensino-superior']['GET'] = 'InstituicaoEnsinoSuperiorController/findAll';
$route['instituicoes-ensino-superior']['POST'] = 'InstituicaoEnsinoSuperiorController/create';
$route['instituicoes-ensino-superior/(:num)']['PUT'] = 'InstituicaoEnsinoSuperiorController/update/$1';
$route['instituicoes-ensino-superior/(:num)']['DELETE'] = 'InstituicaoEnsinoSuperiorController/delete/$1';


// Departamento : Wellerson
$route['departamentos/(:any)']['GET'] = 'DepartamentoController/findById/$1';
$route['departamentos']['GET'] = 'DepartamentoController/findAll';
$route['departamentos']['POST'] = 'DepartamentoController/create';
$route['departamentos/(:any)']['PUT'] = 'DepartamentoController/update/$1';
$route['departamentos/(:any)']['DELETE'] = 'DepartamentoController/delete/$1';


// Curso : Wellerson
$route['cursos/(:any)']['GET'] = 'CursoController/findById/$1';
$route['cursos']['GET'] = 'CursoController/findAll';
$route['cursos']['POST'] = 'CursoController/create';
$route['cursos/(:any)']['PUT'] = 'CursoController/update/$1';
$route['cursos/(:any)']['DELETE'] = 'CursoController/delete/$1';


// Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaController/findAll';
$route['disciplinas/(:any)/(:num)']['GET'] = 'DisciplinaController/findById/$1/$2';
$route['disciplinas']['POST'] = 'DisciplinaController/create';
$route['disciplinas/(:any)/(:num)']['PUT'] = 'DisciplinaController/update/$1/$2';
$route['disciplinas/(:any)/(:num)']['DELETE'] = 'DisciplinaController/delete/$1/$2';



// Unidade de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoController/findAll';
$route['unidades-ensino/(:any)']['GET'] = 'UnidadeEnsinoController/findById/$1';
$route['unidades-ensino']['POST'] = 'UnidadeEnsinoController/create';
$route['unidades-ensino/(:any)']['PUT'] = 'UnidadeEnsinoController/update/$1';
$route['unidades-ensino/(:any)']['DELETE'] = 'UnidadeEnsinoController/delete/$1';



// Projeto Pedagógico de Curso : Guilherme
$route['projetos-pedagogicos-curso/(:any)']['GET'] = 'ProjetoPedagogicoCursoController/findById/$1';
$route['projetos-pedagogicos-curso']['GET'] = 'ProjetoPedagogicoCursoController/findAll';
$route['cursos/(:any)/projetos-pedagogicos-curso']['GET'] = 'ProjetoPedagogicoCursoController/findByCodCurso/$1';
$route['projetos-pedagogicos-curso']['POST'] = 'ProjetoPedagogicoCursoController/create';
$route['projetos-pedagogicos-curso/(:any)']['PUT'] = 'ProjetoPedagogicoCursoController/update/$1';
$route['projetos-pedagogicos-curso/(:any)']['DELETE'] = 'ProjetoPedagogicoCursoController/delete/$1';



// Depêndencia : Guilherme
$route['dependencias/(:any)/(:any)']['GET'] = 'DependenciaController/findById/$1/$2';
$route['dependencias']['GET'] = 'DependenciaController/findAll';
$route['projetos-pedagogicos-curso/(:any)/dependencias']['GET'] = 'DependenciaController/findByCodPpc/$1';
$route['dependencias']['POST'] = 'DependenciaController/create';
$route['dependencias/(:any)/(:any)']['PUT'] = 'DependenciaController/update/$1/$2';
$route['dependencias/(:any)/(:any)']['DELETE'] = 'DependenciaController/delete/$1/$2';



// Componente Curricular : Hadamo
$route['componentes-curriculares']['GET'] = 'ComponenteCurricularController/findAll';
$route['componentes-curriculares/(:any)']['GET'] = 'ComponenteCurricularController/findByCodCompCurric/$1';
$route['projetos-pedagogicos-curso/(:any)/componentes-curriculares']['GET'] = 'ComponenteCurricularController/findByCodPpc/$1';
$route['componentes-curriculares/tipos']['GET'] = 'ComponenteCurricularController/findTipos';
$route['componentes-curriculares']['POST'] = 'ComponenteCurricularController/create';
$route['componentes-curriculares/(:any)']['PUT'] = 'ComponenteCurricularController/update/$1';
$route['componentes-curriculares/(:any)']['DELETE'] = 'ComponenteCurricularController/delete/$1';


// Correspondencia : Hadamo
$route['correspondencias']['GET'] = 'CorrespondenciaController/findAll';
$route['projetos-pedagogicos-curso/(:any)/correspondencias/(:any)']['GET'] = 'CorrespondenciaController/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:any)/correspondencias/(:any)']['GET'] = 'CorrespondenciaController/findByCodCompCurric/$1/$2';
$route['correspondencias']['POST'] = 'CorrespondenciaController/create';
$route['correspondencias/(:any)/(:any)']['PUT'] = 'CorrespondenciaController/update/$1/$2';
$route['correspondencias/(:any)/(:any)']['DELETE'] = 'CorrespondenciaController/delete/$1/$2';



// Transicao : Hadamo
$route['transicoes']['GET'] = 'TransicaoController/findAll';
$route['unidades-ensino/(:any)/transicoes']['GET'] = 'TransicaoController/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:any)/transicoes']['GET'] = 'TransicaoController/findByCodPpc/$1';
$route['transicoes']['POST'] = 'TransicaoController/create';
$route['transicoes/(:any)/(:any)']['PUT'] = 'TransicaoController/update/$1/$2';
$route['transicoes/(:any)/(:any)']['DELETE'] = 'TransicaoController/delete/$1/$2';



// Usuario : Elyabe
$route['usuarios']['GET'] = 'UsuarioController/findAll';
$route['usuarios/(:any)']['GET'] = 'UsuarioController/findById/$1';
$route['usuarios']['POST'] = 'UsuarioController/create';
$route['usuarios/(:any)']['PUT'] = 'UsuarioController/update/$1';
$route['usuarios/(:any)']['DELETE'] = 'UsuarioController/delete/$1';
$route['usuarios/login']['POST'] = 'UsuarioController/login';

$route['usuarios/test']['GET'] = 'UsuarioController/test';


$route['uuid']['GET'] = 'Welcome/getUUID';