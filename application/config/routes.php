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
| This is not exactly a route, but allows you to automatically route
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
$route['instituicoes-ensino-superior/(:num)']['get'] = 'InstituicaoEnsinoSuperiorCtl/getById/$1';
$route['instituicoes-ensino-superior']['get'] = 'InstituicaoEnsinoSuperiorCtl/getAll';

//Departamento : Wellerson
$route['departamentos/(:num)']['get'] = 'DepartamentoCtl/getById/$1';
$route['departamentos']['get'] = 'DepartamentoCtl/getAll';

//Curso : Wellerson
$route['cursos/(:num)']['get'] = 'CursoCtl/getById/$1';
$route['cursos']['get'] = 'CursoCtl/getAll';


# Rota para Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaCtl/findAll';
$route['disciplinas/(:num)/(:num)']['GET'] = 'DisciplinaCtl/findById/$1/$2';

# Rota para Unidades de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoCtl/findAll';
$route['unidades-ensino/(:num)']['GET'] = 'UnidadeEnsinoCtl/findById/$1';

//Projeto Pedagógico de Curso  : Guilherme

$route['projetos-pedagogicos-curso/(:num)'] = 'ProjetoPedagogicoCursoCtl/findById/$1/';
$route['projetos-pedagogicos-curso'] = 'ProjetoPedagogicoCursoCtl/findAll/';

//Depêndencia : Guilherme

$route['dependencias/(:num)/(:num)'] = 'DependenciaCtl/findById/$1/$2/';
$route['dependencias'] = 'DependenciaCtl/findAll/';
$route['projetos-pedagogicos-curso/(:num)/dependencias'] = 'DependenciaCtl/findByIdPpc/$1/';

//Componente Curricular : Hadamo
$route['componentes-curriculares'] = 'ComponenteCurricularCtl/findAll';
$route['componentes-curriculares/(:num)'] = 'ComponenteCurricularCtl/findByCodCompCurric/$1';
$route['projetos-pedagogicos-curso/(:num)/componentes-curriculares'] = 'ComponenteCurricularCtl/findByCodPpc/$1';

//Correspondencia : Hadamo
$route['correspondencias'] = 'CorrespondenciaCtl/findAll';
$route['projetos-pedagogicos-curso/(:num)/correspondencias/(:num)'] = 'CorrespondenciaCtl/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:num)/correspondencias'] = 'CorrespondenciaCtl/findByCodCompCurric/$1';

//Transicao : Hadamo
$route['transicoes'] = 'TransicaoCtl/findAll';
$route['unidades-ensino/(:num)/transicoes'] = 'TransicaoCtl/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:num)/transicoes'] = 'TransicaoCtl/findByCodPpc/$1';



