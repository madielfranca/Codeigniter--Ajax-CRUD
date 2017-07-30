<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('person_model','person');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('person_view');
	}

	public function listar_ajax()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->id;
			$row[] = $person->nome;

		

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Deletar</a><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" style="margin-left: 4px;" onclick="visualizar('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Visualizar</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

		public function editar_ajax($id)
	{
		$data = $this->person->get_by_id($id);
		echo json_encode($data);
	}

	public function adicionar_ajax()
	{
		$this->_validate();
		$data = array(
				'nome' => $this->input->post('nome'),
				'pessoal' => $this->input->post('pessoal'),
				'Etrabalho' => $this->input->post('Etrabalho'),
				'residencial' => $this->input->post('residencial'),
				'trabalho' => $this->input->post('trabalho'),
				'celular' => $this->input->post('celular'),
			);
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function atualizar()
	{
		$this->_validate();
		$data = array(
				'nome' => $this->input->post('nome'),
				'pessoal' => $this->input->post('pessoal'),
				'Etrabalho' => $this->input->post('Etrabalho'),
				'residencial' => $this->input->post('residencial'),
				'trabalho' => $this->input->post('trabalho'),
				'celular' => $this->input->post('celular'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function deletar($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nome') == '')
		{
			$data['inputerror'][] = 'nome';
			$data['error_string'][] = 'Esse campo é obrigatório ';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
