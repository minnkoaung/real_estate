<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Properties extends Admin_Controller {
    /**
     * @var string
     */
    private $_redirect_url;
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        // load the language files
        $this->lang->load('properties');
        // load the users model
        $this->load->model('properties_model');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/properties'));
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "created_at");
        define('DEFAULT_DIR', "desc");
        // use the url in session (if available) to return to the previous filter/sorted/paginated list
        if ($this->session->userdata(REFERRER))
        {
            $this->_redirect_url = $this->session->userdata(REFERRER);
        }
        else
        {
            $this->_redirect_url = THIS_URL;
        }
    }
    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/
    /**
     * User list page
     */
    public function index()
    {
        // get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;
        // get filters
        $filters = array();
        if ($this->input->get('title'))
        {
            $filters['title'] = $this->input->get('title', TRUE);
        }
        if ($this->input->get('type'))
        {
            $filters['type'] = $this->input->get('type', TRUE);
        }
        if ($this->input->get('price'))
        {
            $filters['price'] = $this->input->get('price', TRUE);
        }
        // build filter string
        $filter = "";
        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }
        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
        // are filters being submitted?
        if ($this->input->post())
        {
            if ($this->input->post('clear'))
            {
                // reset button clicked
                redirect(THIS_URL);
            }
            else
            {
                // apply the filter(s)
                $filter = "";
                if ($this->input->post('title'))
                {
                    $filter .= "&title=" . $this->input->post('title', TRUE);
                }
                if ($this->input->post('type'))
                {
                    $filter .= "&type=" . $this->input->post('type', TRUE);
                }
                if ($this->input->post('price'))
                {
                    $filter .= "&price=" . $this->input->post('price', TRUE);
                }
                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }
        // get list
        $properties = $this->properties_model->get_all($limit, $offset, $filters, $sort, $dir);
        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $properties['total'],
            'per_page'   => $limit
        ));
        // setup page header data
		$this
			->add_js_theme( "users_i18n.js", TRUE )
			->set_title( lang('users title user_list') );
        $data = $this->includes;
        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'properties'      => $properties['results'],
            'total'      => $properties['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );
        // load views
        $data['content'] = $this->load->view('admin/properties/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Add new user
     */
    function add()
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('title', lang('properties input title'), 'required');
       
        $this->form_validation->set_rules('description', lang('properties input title'), 'required');
        $this->form_validation->set_rules('type', lang('properties input type'), 'required');
        $this->form_validation->set_rules('price', lang('properties input price'), 'required');
        $this->form_validation->set_rules('address', lang('properties input address'), 'required');
        $this->form_validation->set_rules('township_id', lang('properties input township'), 'required|numeric');
        $this->form_validation->set_rules('region_id', lang('properties input region'), 'required|numeric');
        $this->form_validation->set_rules('area', lang('properties input area'), 'required|numeric');
        $this->form_validation->set_rules('bedrooms', lang('properties input bedrooms'), 'required|numeric');
        $this->form_validation->set_rules('bathrooms', lang('properties input bathrooms'), 'required|numeric');
        if ($this->form_validation->run() == TRUE)
        {
            // save the new property
            $property_data = array(
                'title'=> $this->input->post('title'),
                'price'=> $this->input->post('price'),
                'type'=> $this->input->post('type'),
                'description'=> $this->input->post('description')
                );
            $saved = $this->properties_model->create($property_data);
            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('users msg add_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('users error add_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            // return to list and display message
            redirect($this->_redirect_url);
        }
        // setup page header data
        $this->set_title( lang('users title user_add') );
        $data = $this->includes;
        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => NULL,
            'password_required' => TRUE
        );
        $content_data['types'] = array("1"=>"Condo");
        $content_data['townships'] = array("1"=>"Sule","2"=>"Bahan");
        $content_data['regions'] = array("1"=>"Yangon","2"=>"Mandalay");
        // load views
        $data['content'] = $this->load->view('admin/properties/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Edit existing user
     *
     * @param  int $id
     */
    public function edit($id = NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }
        // get the data
        $property = $this->properties_model->get($id);
        // if empty results, return to list
        if ( ! $property)
        {
            redirect($this->_redirect_url);
        }
        // validators
        // $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        // $this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username[' . $user['username'] . ']');
        // $this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
        // $this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
        // $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[128]|valid_email|callback__check_email[' . $user['email'] . ']');
        // $this->form_validation->set_rules('language', lang('users input language'), 'required|trim');
        // $this->form_validation->set_rules('status', lang('users input status'), 'required|numeric');
        // $this->form_validation->set_rules('is_admin', lang('users input is_admin'), 'required|numeric');
        // $this->form_validation->set_rules('password', lang('users input password'), 'min_length[5]|matches[password_repeat]');
        // $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'matches[password]');
        if (TRUE)
        {
            // save the changes
            $saved = $this->properties_model->update($property_data, 1);
            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('users msg edit_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('users error edit_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            // return to list and display message
            redirect($this->_redirect_url);
        }
        // setup page header data
        $this->set_title( lang('users title user_edit') );
        $data = $this->includes;
        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => $user,
            'user_id'           => $id,
            'password_required' => FALSE
        );
        // load views
        $data['content'] = $this->load->view('admin/users/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Delete a user
     *
     * @param  int $id
     */
    function delete($id = NULL)
    {
        // make sure we have a numeric id
        if ( ! is_null($id) OR ! is_numeric($id))
        {
            // get user details
            $property = $this->properties_model->get($id);
            if ($property)
            {
                // soft-delete the user
                $delete = $this->properties_model->delete($id);
                if ($delete)
                {
                    $this->session->set_flashdata('message', sprintf(lang('users msg delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
                else
                {
                    $this->session->set_flashdata('error', sprintf(lang('users error delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang('users error user_not_exist'));
            }
        }
        else
        {
            $this->session->set_flashdata('error', lang('users error user_id_required'));
        }
        // return to list and display message
        redirect($this->_redirect_url);
    }
    /**
     * Export list to CSV
     */
    function export()
    {
        // get parameters
        $sort = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir  = $this->input->get('dir')  ? $this->input->get('dir', TRUE)  : DEFAULT_DIR;
        // get filters
        $filters = array();
        if ($this->input->get('username'))
        {
            $filters['username'] = $this->input->get('username', TRUE);
        }
        if ($this->input->get('first_name'))
        {
            $filters['first_name'] = $this->input->get('first_name', TRUE);
        }
        if ($this->input->get('last_name'))
        {
            $filters['last_name'] = $this->input->get('last_name', TRUE);
        }
        // get all users
        $users = $this->users_model->get_all(0, 0, $filters, $sort, $dir);
        if ($users['total'] > 0)
        {
            // manipulate the output array
            foreach ($users['results'] as $key=>$user)
            {
                unset($users['results'][$key]['password']);
                unset($users['results'][$key]['deleted']);
                if ($user['status'] == 0)
                {
                    $users['results'][$key]['status'] = lang('admin input inactive');
                }
                else
                {
                    $users['results'][$key]['status'] = lang('admin input active');
                }
            }
            // export the file
            array_to_csv($users['results'], "users");
        }
        else
        {
            // nothing to export
            $this->session->set_flashdata('error', lang('core error no_results'));
            redirect($this->_redirect_url);
        }
        exit;
    }
    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/
    /**
     * Make sure username is available
     *
     * @param  string $username
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_username($username, $current)
    {
        if (trim($username) != trim($current) && $this->users_model->username_exists($username))
        {
            $this->form_validation->set_message('_check_username', sprintf(lang('users error username_exists'), $username));
            return FALSE;
        }
        else
        {
            return $username;
        }
    }
    /**
     * Make sure email is available
     *
     * @param  string $email
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_email($email, $current)
    {
        if (trim($email) != trim($current) && $this->users_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }
}