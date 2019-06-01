﻿@extends('admin.layout')
@section('content')


        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>تعديل محتوى الموقع</h2>
                        <h5>صفحة من نحن </h5>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span>من نحن </span>
                            </div>
                            @if(count($home)>0)
                                @foreach($home as $h)
                            <div class="panel-body">
                                <div class="row">
                                    <form role="form"  action="{{route('saveinfo')}}" method="post" enctype="multipart/form-data" novalidate>
                                        {{csrf_field()}}
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="text-box col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="panel panel-back noti-box">
                                                    
                                                    <div class="form-group">
                                                        <label>نص من نحن</label>
                                                        <textarea class="form-control" style="max-width: 100%" rows="4" name="a_tt1"
                                                            oninvalid="this.setCustomValidity('نص الصورة مطلوب')"
                                                            oninput="this.setCustomValidity('')" required> {{$h->about_text1}} </textarea>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label>صورة من نحن</label>
                                                        <input class="form-control-file" type="file" name="a_m1"
                                                            accept="image/x-png,image/gif,image/jpeg"
                                                            oninvalid="this.setCustomValidity('الصورة 1 مطلوبة')"
                                                            oninput="this.setCustomValidity('')" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-box col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="panel panel-back noti-box">
                                                    <div class="form-group">
                                                        <label>نص  مهمتنا</label>
                                                        <textarea class="form-control" style="max-width: 100%" rows="7  " name="a_tt2"
                                                            oninvalid="this.setCustomValidity('نص الصورة مطلوب')"
                                                            oninput="this.setCustomValidity('')" required> {{$h->about_text2}} </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-box col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="panel panel-back noti-box">
                                                    <div class="form-group">
                                                        <label>نص رؤيتنا</label>
                                                        <textarea class="form-control" style="max-width: 100%" rows="7" name="a_tt3"
                                                            oninvalid="this.setCustomValidity('نص الترحيب مطلوب')"
                                                            oninput="this.setCustomValidity('')" required> {{$h->about_text3}} </textarea>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="text-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button type="submit" class="btn btn-success submit-btn"
                                                    style="display: block;margin-right: auto;margin-left: auto; ">حفظ
                                                    التعديلات</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               @endforeach
                @endif
            </div>
        </div>
    </div>


   @endsection