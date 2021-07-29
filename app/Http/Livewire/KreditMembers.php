<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\KreditMember;
class KreditMembers extends Component
{
    public $kredit_members, $name, $email, $address, $phone_number, $gender, $jenis_kredit, $card_number, $kredit_member_id;
    public $isModal = 0;

    public function render()
    {
        $this->kredit_members = KreditMember::orderBy('created_at', 'DESC')->get();
        return view('livewire.kredit-members');
    }

    public function createkredit()
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
        $this->address = '';
        $this->phone_number = '';
        $this->gender = '';
        $this->jenis_kredit = '';
        $this->card_number = '';
        $this->kredit_member_id = '';
    }


    public function store(){
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:kredit_members,email,'. $this->kredit_member_id,
            'address' => 'required|string',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
            'jenis_kredit' => 'required',
            'card_number' => 'required|numeric',
        ]);

        KreditMember::updateOrCreate(
            ['id' => $this->kredit_member_id], 
            [
                'name'=>$this->name,
                'email'=>$this->email,
                'address'=>$this->address,
                'phone_number'=>$this->phone_number,
                'gender'=>$this->gender,
                'jenis_kredit'=>$this->jenis_kredit,
                'card_number'=>$this->card_number,
            ]
        );

        session()->flash('message', $this->kredit_member_id ? $this->name . ' Berhasil Diperbaharui!':$this->name . ' Berhasil Ditambahkan!');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id){
        $kredit_member = KreditMember::find($id);
        $this->kredit_member_id = $id;
        $this->name = $kredit_member->name;
        $this->email = $kredit_member->email;
        $this->phone_number = $kredit_member->phone_number;
        $this->gender = $kredit_member->gender;
        $this->jenis_kredit = $kredit_member->jenis_kredit;
        $this->card_number = $kredit_member->card_number;

        $this->openModal();
    }

    public function delete($id)
    {
        $kredit_member = KreditMember::find($id);
        $kredit_member->delete(); 
        session()->flash('message', $kredit_member->name . ' Berhasil Dihapus!');
    }
}
