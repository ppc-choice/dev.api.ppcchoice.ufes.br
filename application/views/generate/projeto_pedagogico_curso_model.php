<?php
class Projeto_pedagogico_curso_model extends CI_Model
{

	private $tbl_projeto_pedagogico_curso = 'projeto_pedagogico_curso';
		function Projeto_pedagogico_curso_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('ano_aprovacao', $data['ano_aprovacao']);
		$this->db->set('ch_total', $data['ch_total']);
		$this->db->set('ch_total_atividade_cmplt', $data['ch_total_atividade_cmplt']);
		$this->db->set('ch_total_atividade_ext', $data['ch_total_atividade_ext']);
		$this->db->set('ch_total_disciplina_ob', $data['ch_total_disciplina_ob']);
		$this->db->set('ch_total_disciplina_opt', $data['ch_total_disciplina_opt']);
		$this->db->set('ch_total_estagio', $data['ch_total_estagio']);
		$this->db->set('ch_total_projeto_conclusao', $data['ch_total_projeto_conclusao']);
		$this->db->set('cod_curso', $data['cod_curso']);
		$this->db->set('dt_inicio_vigencia', $data['dt_inicio_vigencia']);
		$this->db->set('dt_termino_vigencia', $data['dt_termino_vigencia']);
		$this->db->set('duracao', $data['duracao']);
		$this->db->set('qtd_periodos', $data['qtd_periodos']);
		$this->db->set('situacao', $data['situacao']);
		$this->db->insert($this->tbl_projeto_pedagogico_curso);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_ppc', $id);
		$query = $this->db->get($this->tbl_projeto_pedagogico_curso);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_projeto_pedagogico_curso);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('ano_aprovacao', $data['ano_aprovacao']);
		$this->db->set('ch_total', $data['ch_total']);
		$this->db->set('ch_total_atividade_cmplt', $data['ch_total_atividade_cmplt']);
		$this->db->set('ch_total_atividade_ext', $data['ch_total_atividade_ext']);
		$this->db->set('ch_total_disciplina_ob', $data['ch_total_disciplina_ob']);
		$this->db->set('ch_total_disciplina_opt', $data['ch_total_disciplina_opt']);
		$this->db->set('ch_total_estagio', $data['ch_total_estagio']);
		$this->db->set('ch_total_projeto_conclusao', $data['ch_total_projeto_conclusao']);
		$this->db->set('cod_curso', $data['cod_curso']);
		$this->db->where('cod_ppc', $data['cod_ppc']);
		$this->db->set('dt_inicio_vigencia', $data['dt_inicio_vigencia']);
		$this->db->set('dt_termino_vigencia', $data['dt_termino_vigencia']);
		$this->db->set('duracao', $data['duracao']);
		$this->db->set('qtd_periodos', $data['qtd_periodos']);
		$this->db->set('situacao', $data['situacao']);
		$this->db->update($this->tbl_projeto_pedagogico_curso);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_ppc', $id);
		$this->db->delete($this->tbl_projeto_pedagogico_curso);

		return $this->db->affected_rows();
	}

}