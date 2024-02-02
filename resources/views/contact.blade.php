@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col bold mt-5" style="color: #0038CF; font-size: 16px; text-align:center;">
        <h1>Contact Us</h1>
    </div>
  </div>
  <div class="row">
    <div class="col" style="color: #101828; text-align:center; font-weight: 500;">
        Ada pertanyaan atau komentar? Kirimkan pesan kepada kami!
    </div>
  </div>

  <div class="container shadow shadow-s">
    <div class="row p-5">
        <div class="col-4 p-4 m-4 text-white rounded" style="background-color: #0038CF">
            <h3 style="font-weight: 600;">Contact Information</h3>
            <p>Say Somethin To Start A Live Chat!</p>
            <ul class="mt-5">
                <li class="mb-4"><i class="bi bi-telephone-outbound"></i> +628 123456789</li>
                <li class="mb-4"><i class="bi bi-wallet-fill"></i> edukas1@gmail.com</li>
                <li class="mb-4"><i class="bi bi-arrow-down"></i> Jl. Garuda, Blok A no.1 Jakarta Selatan</li>
            </ul>
        </div>
        <div class="col-7 p-4 m-3">
            <div class="mb-3 row">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="First Name">
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Last Name">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Email">
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Phone Number">
                </div>
            </div>
            <h4>Select Subject?</h4>
            <div class="mb-3 row">
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            General Inquiry
                        </label>
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Payment
                        </label>
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Account Problem
                        </label>
                      </div>
                </div>
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            <p style="font-size: 15px;">Change Password</p>
                        </label>
                      </div>
                </div>
                <div class="mb-3">
                    <label>Message</label>
                    <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
  </div>
@endsection