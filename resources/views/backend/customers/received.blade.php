@extends('backend.layouts.master')
@section('content')
<div class="content">
    @include('backend.layouts.notification')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Trả tiền cho khách hàng: {{\App\Models\User::where('id',$customer->id)->value('full_name')}}
                    </h2>
                   
                </div>
    <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="{{route('customer.storereceived')}}">
                @csrf
                <div class="intro-y box p-5">
                    <div>
                        <input type="hidden" name="id" value = "{{$customer->id}}"/>
                        <?php
                            if ($customer->budget < 0)
                            {
                                $classname = "text-danger";
                                $text_c="Khách hàng còn nợ tiền";
                            }
                            else
                            {
                                $classname = "text-primary";
                                $text_c="Cửa hàng còn nợ tiền";
                            }
                            ?>
                       <div class="{{ $classname}}"> <label for="regular-form-1 " class="form-label font-medium ">Tổng công nợ hiện tại :</label> 
                        {{number_format($customer->budget  ,0,'.',',')}} ({{ $text_c}}) </div>
                       
                    </div>
                    <div  >
                        <label for="regular-form-1" class="form-label">Số tiền </label>
                        <input id="paid_amount" name="paid_amount" 
                        value = "{{$customer->budget<0?-$customer->budget : $customer->budget}}"
                            type="number" class="form-control" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Ghi chú </label>
                        <input id="content" name="content" value = ""
                            type="text" class="form-control" placeholder="">
                    </div>
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:70px  " class="form-select-label"  for="status">Tài khoản</label>
                           
                            <select name="bank_id" class="form-select mt-2 sm:mr-2"   >
                                @foreach ($bankaccounts as $bank )
                                    <option value ="{{$bank->id}}">{{$bank->title}}  </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>    {{$error}} </li>
                                    @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>                   
                
    
</div>

@endsection
@section('scripts')
<script>
   
</script>

@endsection
