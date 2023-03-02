<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesWired extends Component
{
      use WithPagination;
    // public $categories;
    public $addNewCategory;
    public $inputs = [];
    public $category_id;
    public $btn_text;
    protected $listeners = ['confirm_delete_category_alert',];
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required',
        'status' => 'required',

    ];
    // public function mount(){
    //     dd('yo');
    // }

    public function new_category()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewCategory = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_category_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewCategory == true ? 'Save' : 'Save Changes';

    }

    public function edit_category($category_id){
        $this->category_id=$category_id;

        $this->addNewCategory = false;
        $this->inputs = CategoryModel::where(['id'=> $category_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_category_modal');
        $this->btn_text = $this->addNewCategory == true ? 'Save' : 'Save Changes';


    }
    public function delete_category($category_id){
        $this->category_id=$category_id;
        $this->dispatchBrowserEvent('show_delete_category_alert');



    }
    public function update_category(){
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        CategoryModel::where(['id'=> $this->category_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_category_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>' Category Updated Successfully']);



    }
    public function confirm_delete_category_alert(){
        CategoryModel::findOrFail($this->category_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>' Category Deleted Successfully']);


    }


    private function array_to_object($array){
        return (object) $array;

    }

    public function submit_add_new_category()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $category=new CategoryModel();
        $validated_data=$this->array_to_object($validated_data);

        $category->name=$validated_data->name;
        $category->status=$this->array_to_object($this->inputs)->status;
        $category->save();
        $this->addNewCategory = false;



        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_category_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'New Category Added Successfully']);





    }

    public function change_category_status($category_id,$category_status){
        CategoryModel::where(['id'=> $category_id])->update(['status'=>$category_status=="1"?0:1]);
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'Category Status Added Successfully']);


    }




    public function render()
    {
        $categories = CategoryModel::latest()->paginate(2);
        // DD(  $categories);


        return view('livewire.admin.categories.categories-wired')
        ->with(compact('categories'));

    }
}