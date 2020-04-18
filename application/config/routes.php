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


// (GET) Instituicao de Ensino Superior - Wellerson
$route['instituicoes-ensino-superior/(:num)']['GET'] = 'InstituicaoEnsinoSuperiorController/getById/$1';
$route['instituicoes-ensino-superior']['GET'] = 'InstituicaoEnsinoSuperiorController/getAll';

// (GET) Departamento : Wellerson
$route['departamentos/(:num)']['GET'] = 'DepartamentoController/findById/$1';
$route['departamentos']['GET'] = 'DepartamentoController/findAll';

// (GET) Curso : Wellerson
$route['cursos/(:num)']['GET'] = 'CursoController/findById/$1';
$route['cursos']['GET'] = 'CursoController/findAll';


# (GET) Rota para Disciplinas : Gabriel
$route['disciplinas']['GET'] = 'DisciplinaController/findAll';
$route['disciplinas/(:num)/(:num)']['GET'] = 'DisciplinaController/findById/$1/$2';

# (GET) Rota para Unidades de Ensino : Gabriel
$route['unidades-ensino']['GET'] = 'UnidadeEnsinoController/findAll';
$route['unidades-ensino/(:num)']['GET'] = 'UnidadeEnsinoController/findById/$1';

// (GET) Projeto Pedagógico de Curso  : Guilherme

$route['projetos-pedagogicos-curso/(:num)']['GET'] = 'ProjetoPedagogicoCursoController/findById/$1';
$route['projetos-pedagogicos-curso']['GET'] = 'ProjetoPedagogicoCursoController/findAll';

// (GET) Depêndencia : Guilherme

$route['dependencias/(:num)/(:num)']['GET'] = 'DependenciaController/findById/$1/$2';
$route['dependencias']['GET'] = 'DependenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/dependencias']['GET'] = 'DependenciaController/findByIdPpc/$1';

// (GET) Componente Curricular : Hadamo
$route['componentes-curriculares']['GET'] = 'ComponenteCurricularController/findAll';
$route['componentes-curriculares/(:num)']['GET'] = 'ComponenteCurricularController/findByCodCompCurric/$1';
$route['projetos-pedagogicos-curso/(:num)/componentes-curriculares']['GET'] = 'ComponenteCurricularController/findByCodPpc/$1';

// (GET) Correspondencia : Hadamo
$route['correspondencias']['GET'] = 'CorrespondenciaController/findAll';
$route['projetos-pedagogicos-curso/(:num)/correspondencias/(:num)']['GET'] = 'CorrespondenciaController/findAllByCodPpc/$1/$2';
$route['componentes-curriculares/(:num)/correspondencias']['GET'] = 'CorrespondenciaController/findByCodCompCurric/$1';

// (GET) Transicao : Hadamo
$route['transicoes']['GET'] = 'TransicaoController/findAll';
$route['unidades-ensino/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodUnidadeEnsino/$1';
$route['projetos-pedagogicos-curso/(:num)/transicoes']['GET'] = 'TransicaoController/findByCodPpc/$1';

// (GET) Usuario : Elyabe
$route['usuarios']['GET'] = 'UsuarioController/findAll';
$route['usuarios/(:num)']['GET'] = 'UsuarioController/findById/$1';

$route['usuarios']['POST'] = 'UsuarioController/adicionarUsuario';

// Test
$route['migrate']['GET'] = 'Welcome/updateSchema';


// (POST) para Unidades de Ensino : Gabriel
$route['unidades-ensino']['POST'] = 'UnidadeEnsinoController/add';
// (POST) para Disciplinas : Gabriel
$route['disciplinas']['POST'] = 'DisciplinaController/add';


// (POST) Instituição de Ensino Superior: Wellerson
$route['instituicoes-ensino-superior']['POST'] = 'InstituicaoEnsinoSuperiorController/add';

// (POST) Departamento: Wellerson
$route['departamentos']['POST'] = 'DepartamentoController/add';

// (POST) Curso: Wellerson
$route['cursos']['POST'] = 'CursoController/add';

// (PUT) Instituição de Ensino Superior: Wellerson
$route['instituicoes-ensino-superior/(:num)']['PUT'] = 'InstituicaoEnsinoSuperiorController/update/$1';

// (PUT) Departamento: Wellerson
$route['departamentos/(:num)']['PUT'] = 'DepartamentoController/update/$1';

// (PUT) Curso: Wellerson
$route['cursos/(:num)']['PUT'] = 'CursoController/update/$1';
//(POST) Componente Curricular : Hadamo
$route['componentes-curriculares']['POST'] = 'ComponenteCurricularController/add';
//(POST) Correspondencia : Hadamo
$route['correspondencias']['POST'] = 'CorrespondenciaController/add';
//(POST) Transicao : Hadamo
$route['transicoes']['POST'] = 'TransicaoController/add';

//(POST) Projeto Pedagoico Curricular : Guilherme
$route['projetos-pedagogicos-curso']['POST'] = 'ProjetoPedagogicoCursoController/add';
//(POST) Dependencia : Guilherme
$route['dependencias']['POST'] = 'DependenciaController/add';

//(PUT) Componente Curricular: Hadamo

$route['componentes-curriculares/(:num)']['PUT'] = 'ComponenteCurricularController/update/$1';
//(PUT) Correspondencia: Hadamo
$route['correspondencias/(:num)/(:num)']['PUT'] = 'CorrespondenciaController/update/$1/$2';
//(PUT) Transicao: Hadamo
$route['transicao/(:num)/(:num)']['PUT'] = 'TransicaoController/update/$1/$2';

// (PUT) para Unidades de Ensino : Gabriel
$route['unidades-ensino/(:num)']['PUT'] = 'UnidadeEnsinoController/update/$1';
// (PUT) para Disciplinas : Gabriel
$route['disciplinas/(:num)/(:num)']['PUT'] = 'DisciplinaController/update/$1/$2';
