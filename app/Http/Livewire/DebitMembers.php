<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\DebitMember;
class DebitMembers extends Component
{
    public $debit_members, $name, $email, $phone_number, $gender, $jenis_debit, $card_number, $debit_member_id;
    public $isModal = 0;

    public function render()
    {
        $this->debit_members = DebitMember::orderBy('created_at', 'DESC')->get();
        return view('livewire.debit-members');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal(){
        $this->isModal = true;
    }

    public function closeModal(){
        $this->isModal = false;
    }

    public function resetFields(){
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->gender = '';
        $this->jenis_debit = '';
        $this->card_number = '';
        $this->debit_member_id = '';
    }


    public function store(){
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:debit_members,email,'. $this->debit_member_id,
            'phone_number' => 'required|numeric',
            'gender' => 'required',
            'jenis_debit' => 'required',
            'card_number' => 'required|numeric',
        ]);

        DebitMember::updateOrCreate(
            ['id' => $this->debit_member_id], 
            [
                'name'=>$this->name,
                'email'=>$this->email,
                'phone_number'=>$this->phone_number,
                'gender'=>$this->gender,
                'jenis_debit'=>$this->jenis_debit,
                'card_number'=>$this->card_number,
            ]
        );

        session()->flash('message', $this->debit_member_id ? $this->name . ' Berhasil Diperbaharui!':$this->name . ' Berhasil Ditambahkan!');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id){
        $debit_member = DebitMember::find($id);
        $this->debit_member_id = $id;
        $this->name = $debit_member->name;
        $this->email = $debit_member->email;
        $this->phone_number = $debit_member->phone_number;
        $this->gender = $debit_member->gender;
        $this->jenis_debit = $debit_member->jenis_debit;
        $this->card_number = $debit_member->card_number;

        $this->openModal();
    }

    public function delete($id)
    {
        $debit_member = DebitMember::find($id);
        $debit_member->delete(); 
        session()->flash('message', $debit_member->name . ' Berhasil Dihapus!');
    }
}
