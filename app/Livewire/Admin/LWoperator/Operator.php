<?php

namespace App\Livewire\Admin\LWoperator;
use App\Livewire\Admin\SuperAdminAuth as AdminSuperAdminAuth;
use App\Models\User as ModelUser;
use App\Models\Opd as ModelOpd;
use App\Models\Operator as ModelsOperator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

class Operator extends AdminSuperAdminAuth
{  
    use WithPagination; 
    public $search = '';
    public $operator;
    
    // Isi tabel
    public $name;
    public $email;
    public $kontak;

    //Model Name Rule
    public $namaOperator;
    public $emailOperator;
    public $kontakOperator;
    public $passwordOperator;
    public $isAdmin;
    public $opd;


    public $isEdit = false;
    public $existingFotoProfile = null;
    public $operatorId = null;

    // Modal state
    public $showModal = false;
    public $showDetailModal = false;
    public $modalTitle = '';

    protected function rules()
    {
        $rules = [
            'namaOperator'      => 'required|string',
            'emailOperator'     => 'required|email',
            'kontakOperator'    => 'required|string',
            'passwordOperator'  => 'required|string',
            'opd'               => 'required',
        ];
        return $rules;
    }


    public function openTambahModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->modalTitle = 'Tambah Operator Baru';
        $this->showModal = true;
    }

       public function openEditModal($operatoriId)
    {
        $operator = ModelsOperator::find($operatoriId);

        if ($operator) {
            $this->operatorId       = $operator->id;
            $this->namaOperator     = $operator->name;
            $this->emailOperator    = $operator->email;
            $this->kontakOperator   = $operator->kontak; 
            $this->passwordOperator = $operator->password; 
            $this->opd              = $operator->opd->nama_opd; 
            $this->isEdit           = true;
            $this->modalTitle       = 'Edit Data Operator';
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDetailModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->namaOperator = '';
        $this->emailOperator = '';
        $this->kontakOperator = '';
        $this->passwordOperator = '';
        $this->operatorId = null;
        $this->isEdit = false;
        $this->resetErrorBag();
    }


     public function simpan()
    {

        $this->validate();

           if ($this->isEdit) {
                // Update data
                $operator = ModelsOperator::find($this->operatorId);
                $operator->update([
                    'name'      => $this->namaOperator,
                    'email'     => $this->emailOperator,
                    'is_admin'  => 0,
                    'opd_id'    => $this->opd,
                    'kontak'    => $this->kontakOperator,
                    'password'  => bcrypt($this->passwordOperator),
                ]);
                $this->dispatch('success-add-data',message: 'Data '.$this->namaOperator.' Berhasil di diperbarui');
            } else {
                // Tambah data baru
                ModelsOperator::create([
                    'name'      => $this->namaOperator,
                    'email'     => $this->emailOperator,
                    'is_admin'  => 0,
                    'opd_id'    => $this->opd,
                    'kontak'    => $this->kontakOperator,
                    'password'  => bcrypt($this->passwordOperator),
                ]);
                $this->dispatch('success-add-data',message: $this->namaOperator .' Berhasil Berhasil di Tambahkan');
            }
            $this->closeModal();
    }

     #[On('delete-data-operator')]
    public function hapus($id)
    {
        try {
            $operator = ModelsOperator::find($id);
                $operator->delete();
                $this->dispatch('success-delete-data',message: $operator->name .' Telah dihapus sebagai operator');
                $this->closeModal();
            
        } catch (\Exception $e) {
            $this->dispatch('failed-delete-data',message: 'Gagal Menghapus Data Operator');
        }
    }

    // Layout digunakan agar load css custome
     #[Layout('components.layouts.admin',['pageTitle' => 'Operator'])]
    public function render()
    {
        $operator = ModelUser::query()
                    ->where('name', 'like', "%{$this->search}%")
                    ->latest()
                    ->paginate(10);

        $opd = ModelOpd::all();

        return view('livewire.admin.LW_operator.operator',['operators'=>$operator],['opds'=>$opd]);
    }
}
