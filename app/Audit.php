<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model {
	protected $fillable = array('event', 'type', 'old_value', 'new_value', 'ip', 'user_agent');
}

?>