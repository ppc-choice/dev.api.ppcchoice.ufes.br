<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exacontrollery a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//Instituicao de Ensino Superior - Wellerson
$route['instituicoes-ensino-superior/(:num)']['GET'] = 'InstituicaoEnsinoSuperiorController/getById/$1';
$route['instituicoes-ensino-superior']['GET'] = 'InstituicaoEnsinoSuperiorController/getAll';

//Departamento : Wellerson
$route['departamentos/(:num)']['GET'] = 'DepartamentoController/findById/$1';
$route['departamentos']['GET'] = 'DepartamentoController/findAll';

//Curso : Wellerson
$route['cursos/(:num)']['GET'] = 'CursoController/findById/$1';
$route['cursos']['GET'] = 'CursoController/findAll';


# Rota para Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaController/findAll';
$route['disciplinas/(:num)/(:num)']['GET'] = 'DisciplinaController/findById/$1/$2';

# Rota para Unidades de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoController/findAll';
$route['unidades-ensino/(:num)']['GET'] = 'UnidadeEnsinoController/findById/$1';

//Projeto Pedagógico de Curso  : Guilherme

$route['projetos-pedagogicos-curso/(:num)'] = 'ProjetoPedagogicoCursoController/findById/$1';
$route['projetos-pedagogicos-curso'] = 'ProjetoPedagogicoCursoController/findAll';

//Depêndencia : Guilherme

$route['dependencias/(:num)/(:num)'] = 'DependenciaController/findById/$1/$2';
$route['dependencias'] = 'DependenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/dependencias'] = 'DependenciaController/findByIdPpc/$1';

//Componente Curricular : Hadamo
$route['componentes-curriculares'] = 'ComponenteCurricularController/findAll';
$route['componentes-curriculares/(:num)'] = 'ComponenteCurricularController/findByCodCompCurric/$1';
$route['projetos-pedagogicos-curso/(:num)/componentes-curriculares'] = 'ComponenteCurricularController/findByCodPpc/$1';

//Correspondencia : Hadamo
$route['correspondencias'] = 'CorrespondenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/correspondencias/(:num)'] = 'CorrespondenciaController/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:num)/correspondencias'] = 'CorrespondenciaController/findByCodCompCurric/$1';

//Transicao : Hadamo
$route['transicoes'] = 'TransicaoController/findAll';
$route['unidades-ensino/(:num)/transicoes'] = 'TransicaoController/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:num)/transicoes'] = 'TransicaoController/findByCodPpc/$1';

// Usuario : Elyabe
$route['usuarios'] = 'UsuarioController/findAll';
$route['usuarios/(:num)'] = 'UsuarioController/findById/$1';

// Test
$route['migrate'] = 'Welcome/updateSchema';