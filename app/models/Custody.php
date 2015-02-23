<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Custody extends Model {
  use SoftDeletingTrait;

  protected $table = 'custody';

  protected $fillable = ['name', 'characteristic', 'responsible', 'date', 'time',
                         'description', 'details', 'signature', 'signature_name',
                         'signature_remark', 'signature_signed', 'signature_ip',
                         'signature_date', 'signature_time'];

  protected $rules = [
    'name' => 'required',
    'characteristic' => 'required',
    'responsible' => 'required',
    'date' => 'required|date'
  ];

}
