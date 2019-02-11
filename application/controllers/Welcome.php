<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->helper("url");
		$this->load->database();
        $this->load->model("tester_model");
        $this->load->model("question_model");
        $this->load->model("value_model");
        $this->load->model("answer_model");
        $this->load->model("category_model");
	}
	
	public function index()
	{
	    $data['baseurl'] = $this->config->base_url();
		$testers = $this->tester_model->getAll();
		$total_completed = 0;
        $day7_completed = 0;
		$today_count = 0;
		$today = date("Y-m-d");
        $day7 = date("Y-m-d", time() - 7 * 24 * 3600);
		foreach($testers as $tester)
		{
			if ($tester['email'] != "") {
                $total_completed++;
                if ($tester['test_date'] >= $day7)
                    $day7_completed++;
            }
			if ($tester['test_date'] == $today)
				$today_count++;
		}
        $data['total_completed'] = $total_completed + 657211;
        $data['day7_completed'] = $day7_completed + 721;
        $data['today_count'] = $today_count + date("i") * 5;
		
		$this->load->view('welcome_message', $data);
	}
	
	public function debug($obj){
		$fp = fopen("debug.txt", 'a');
		fputs($fp, print_r($obj, true) . "\n");
		fclose($fp);
	}
	
	public function create_test()
	{
		$params['gender'] = $_REQUEST['gender'];
		$params['age_grp'] = $_REQUEST['age_grp'];
		$params['test_date'] = date("Y-m-d");
		
		$tester_id = $this->tester_model->insert($params);
		$questions = $this->question_model->getAll();
		$total_questions = count($questions);
		$questions = $this->question_model->getAll(array(), 'id', 'ASC', 5, 0);
		$values = $this->value_model->getAll();
		$h = base64_encode(md5($tester_id));
		$h = preg_replace("/=+$/", "", $h);
		foreach($values as $key => $value)
		{
			unset($values[$key]['value_val']);
		}
		
		die(json_encode(array("tester_id" => $tester_id, "questions" => $questions, "values" => $values, "total_questions" => $total_questions, "hash" => $h)));
	}
	
	public function get_questions(){
		$step = $_REQUEST['step'];
		$tester_id = $_REQUEST['tester_id'];
		$questions = $this->question_model->getAll(array(), 'id', 'ASC', 5, $step * 5);
		$answers = array();
		foreach($questions as $question)
		{
			$answer = $this->answer_model->getOne(array('tester_id' => $tester_id, "question_id" => $question['id']));
			if ($answer)
			$answers['quiz_' . $question['id']] = $answer['value_id'];
		}
		
		die(json_encode(array("answers" => $answers, "questions" => $questions)));
	}
	
	public function set_answer()
	{
		$tester_id = $_REQUEST['tester_id'];
		$question_id = $_REQUEST['question_id'];
		$value_id = $_REQUEST['value_id'];
		$answer = $this->answer_model->getOne(array('tester_id' => $tester_id, "question_id" => $question_id));
		if ($answer)
			$this->answer_model->update(array('tester_id' => $tester_id, "question_id" => $question_id), array('value_id' => $value_id));
		else
			$this->answer_model->insert(array('tester_id' => $tester_id, "question_id" => $question_id, 'value_id' => $value_id));
		die(json_encode(array()));
	}
	
	public function sendmail()
	{
        $data['baseurl'] = $this->config->base_url();
		$hash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : 0;
		$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
		
		if (!$hash || !$name || !$email)
			die("Woooops!");
		
		$testers = $this->tester_model->getAll();
		$curtester = null;
		foreach($testers as $tester)
		{
			if (md5($tester['id']) == base64_decode($hash))
			{
				$curtester = $tester;
				break;
			}
		}
		
		if ($curtester == null)
			die("Woooops!");
		
		$this->tester_model->update(array('id' => $curtester['id']), array('name' => $name, 'email' => $email));
		
		$this->load->view('welcome_email', $data);
	}
	
	public function viewresult($h = "")
	{
        $data['baseurl'] = $this->config->base_url();
		if (!$h)
			die("Woooops! Missing hash.");
		
		$testers = $this->tester_model->getAll();
		$curtester = null;
		$total_count = count($testers);
		$complete_count = 0;
		foreach($testers as $tester)
		{
			if (md5($tester['id']) == base64_decode($h))
			{
				$curtester = $tester;
			}
			if ($tester['name'] != "")
				$complete_count++;
		}
		if (!$curtester)
			die("Woooops! Incorrect hash.");
		
		$categories = $this->category_model->getAll();
		$results = array();
		foreach($categories as $cat)
		{
			$result = array();
			$result['category'] = $cat['cat_name'];
			$result['description'] = $cat['cat_description'];
			$result['marks'] = 0;
			$questions = $this->question_model->getAll(array("cat_id" => $cat['id']));
			foreach($questions as $question)
			{
				$answer = $this->answer_model->getOne(array("tester_id" => $curtester['id'], "question_id" => $question['id']));
				if ($answer)
				{
					$result['marks'] += $answer['value_id'] - 1;
				}
			}
			$results[] = $result;
		}
		
		$data['results'] = $this->sortbymarks($results);
		
		$data['total_count'] = $total_count;
		$data['complete_count'] = $complete_count;
		
		$this->load->view('welcome_result', $data);
	}
	
	private function sortbymarks($results){
		$res = array();
		while(count($results) > 0)
		{
			$k = $this->getMaxItem($results);
			$res[] = $results[$k];
			unset($results[$k]);
		}
		return $res;
	}
	
	private function getMaxItem($arr){
		$max_mark = 0;
		$max_mark_key = 0;
		$i = 0;
		foreach($arr as $key => $item)
		{
			if ($i++ == 0)
				$max_mark_key = $key;
			if ($item['marks'] > $max_mark)
			{
				$max_mark = $item['marks'];
				$max_mark_key = $key;
			}
		}
		return $max_mark_key;
	}
	
	public function testpage()
	{
        $data['baseurl'] = $this->config->base_url();
		$questions = $this->question_model->getAll();
		$values = $this->value_model->getAll();
		
		$data['questions'] = $questions;
		$data['values'] = $values;
		
		$this->load->view('welcome_test', $data);
	}
	
	public function testpage2()
	{
        $data['baseurl'] = $this->config->base_url();
		$questions = $this->question_model->getAll();
		$values = $this->value_model->getAll();
		
		$data['questions'] = $questions;
		$data['values'] = $values;
		
		$this->load->view('welcome_test2', $data);
	}
	
	public function test_values()
	{
		$params['gender'] = 1;
		$params['age_grp'] = 1;
		$params['name'] = "Quiz Tester";
		$params['email'] = "tester@quizteam.com";
		$params['test_date'] = date("Y-m-d");
		
		$tester_id = $this->tester_model->insert($params);
		
		for($i = 1; $i < 85; $i++)
		{
			$this->answer_model->insert(array('tester_id' => $tester_id, "question_id" => $i, 'value_id' => $_REQUEST["q$i"]));
		}
		
		$h = base64_encode(md5($tester_id));
		$h = preg_replace("/=+$/", "", $h);
		$url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/quiz/welcome/viewresult/$h";
		
		die(json_encode(array("hash" => $h, 'url' => $url)));
	}
}
?>