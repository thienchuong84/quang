<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oop extends MY_Controller
{
	/* Tại sao ta dùng func php magic __set __get ????  ->  automatical set và get
	* Ví dụ với class pbx có các property như : name, host .. ta phải dùng các hàm như setName($value), setHost($value), getName(), getHost() ... khi new pbx eucerin ta chạy các hàm để set cho nó như $eucerin->setName = eucerin ... Vậy class đó có 10 property và ta cần set 2 property ta phải tạo 2 hàm set và 2 hàm get tương ứng rất cực
	* Vậy với hàm __set và __get , ta ko cần 5 hàm trên, chỉ cần sử dụng $pbx->name = eucerin, nó tự động chạy hàm set name cho mình. Ngoài ra ta còn có thể customize được rất nhiều thứ
	*/
	
	// refer : http://blog.newmythmedia.com/blog/show/2016-10-27_Better_Entities_In_CodeIgniter_4
	public $name;
	public $password;

	// public function __get(string $key)
	// {
	// 	if( isset($this->$key) )
	// 		return $this->$key;
	// }

	public function __get(string $key)
	{      
	    // if a set* method exists for this key,        
	    // use that method to insert this value.        
	    if (method_exists($this, $key))
	    {
	        return $this->$key();
	    }
	    if (isset($this->$key))
	    {
	        return $this->$key;
	    }
	}	

	/* Basic __set */
	// public function __set(string $key, $value = null)
	// {
	// 	if( isset($this->$key) )
	// 		$this->$key = $value;
	// }

	/* Advance __set with custom function
	* 
	*/
	public function __set(string $key, $value = null)
	{
		// if a set method exists for this key
		// use method to insert this value
		$method = 'set_'.$key;
		if( method_exists($this, $method) )
		{
			$this->$method($value);
		}
		// A simple insert on existing keys otherwise.
		else if( isset($this->$key) )
		{
			$this->$key = $value;
		}
	}	

	protected function set_password(string $value)
	{
		$this->password = password_hash($value, PASSWORD_BCRYPT);
	}

	// protected function set_last_login(string $value)
	// {
	//     $this->last_login = new DateTime($value);
	// }	

	public function last_login($format=‘Y-m-d H:i:s’)
	{
	    return $this->last_login->format($format);
	}

	/* Whenever you set $user->password = ‘abc’, or $user->last_login = ’10-15-2016 3:42pm’ your custom methods will automatically be called, storing the property as your business needs dictate. Let’s do the same thing for the getters.
	*/































































	/* Ví dụ 1 : http://blog.newmythmedia.com/blog/show/2016-10-27_Better_Entities_In_CodeIgniter_4
	// basic set get
	public function __get(string $key)
	{
	    if (isset($this->$key))
	    {
	        return $this->$key;
	    }
	}

	public function __set(string $key, $value = null)
	{
	    if (isset($this->$key))         
	    {
	        $this->$key = $value;       
	    }
	}

	// advance set get
	public function __set(string $key, $value = null)
	{
	    // if a set* method exists for this key,        
	    // use that method to insert this value.        
	    $method = 'set_'.$key;      
	    if (method_exists($this, $method))      
	    {
	        $this->$method($value);         
	    }
	    // A simple insert on existing keys otherwise.      
	    elseif (isset($this->$key))         
	    {
	        $this->$key = $value;       
	    }
	}	

	protected function set_password(string $value)
	{
	    $this->password = password_hash($value, PASSWORD_BCRYPT);
	}

	protected function set_last_login(string $value)
	{
	    $this->last_login = new DateTime($value);
	}	

	public function __get(string $key)  
	{         
	    // if a set* method exists for this key,        
	    // use that method to insert this value.        
	    if (method_exists($this, $key))         
	    {             
	        return $this->$key();       
	    }     
	    if (isset($this->$key))         
	    { 
	        return $this->$key;         
	    }
	}	

	public function last_login($format=‘Y-m-d H:i:s’)
	{
	    return $this->last_login->format($format);
	}	
	*/





	/* Ví dụ 2: http://www.codeigniter.com/user_guide/database/results.html?highlight=row
	class User {

	        public $id;
	        public $email;
	        public $username;

	        protected $last_login;

	        public function last_login($format)
	        {
	                return $this->last_login->format($format);
	        }

	        public function __set($name, $value)
	        {
	                if ($name === 'last_login')
	                {
	                        $this->last_login = DateTime::createFromFormat('U', $value);
	                }
	        }

	        public function __get($name)
	        {
	                if (isset($this->$name))
	                {
	                        return $this->$name;
	                }
	        }
	}

	$query = $this->db->query("YOUR QUERY");

	$rows = $query->custom_result_object('User');

	foreach ($rows as $row)
	{
	        echo $row->id;
	        echo $row->email;
	        echo $row->last_login('Y-m-d');
	}
	*/


	/* Ví dụ 3: của PHP , cho nó overload thay vì định nghĩa từng property
	Overloading properties via the __get(), __set(), __isset() and __unset() methods
	http://php.net/manual/en/language.oop5.overloading.php#object.set

	class PropertyTest
	{
	    // Location for overloaded data.  
	    private $data = array();

	    // Overloading not used on declared properties. 
	    public $declared = 1;

	    // Overloading only used on this when accessed outside the class.
	    private $hidden = 2;

	    public function __set($name, $value)
	    {
	        echo "Setting '$name' to '$value'\n";
	        $this->data[$name] = $value;
	    }

	    public function __get($name)
	    {
	        echo "Getting '$name'\n";
	        if (array_key_exists($name, $this->data)) {
	            return $this->data[$name];
	        }

	        $trace = debug_backtrace();
	        trigger_error(
	            'Undefined property via __get(): ' . $name .
	            ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'],
	            E_USER_NOTICE);
	        return null;
	    }

	    // As of PHP 5.1.0  
	    public function __isset($name)
	    {
	        echo "Is '$name' set?\n";
	        return isset($this->data[$name]);
	    }

	    // As of PHP 5.1.0 
	    public function __unset($name)
	    {
	        echo "Unsetting '$name'\n";
	        unset($this->data[$name]);
	    }

	    // Not a magic method, just here for example.
	    public function getHidden()
	    {
	        return $this->hidden;
	    }
	}


	echo "<pre>\n";

	$obj = new PropertyTest;

	$obj->a = 1;
	echo $obj->a . "\n\n";

	var_dump(isset($obj->a));
	unset($obj->a);
	var_dump(isset($obj->a));
	echo "\n";

	echo $obj->declared . "\n\n";

	echo "Let's experiment with the private property named 'hidden':\n";
	echo "Privates are visible inside the class, so __get() not used...\n";
	echo $obj->getHidden() . "\n";
	echo "Privates not visible outside of class, so __get() is used...\n";
	echo $obj->hidden . "\n";		
	
	*/
}

/* End of file Oop_Controller.php */
/* Location: ./application/core/Oop_Controller.php */