@extends('layouts.app')
@section('title', 'User Profile Setting')
@section('contents')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="ti-xs ti ti-users me-1"></i>
                            Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-security.html"><i
                                class="ti-xs ti ti-lock me-1"></i> Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-billing.html"><i
                                class="ti-xs ti ti-file-description me-1"></i> Billing & Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                class="ti-xs ti ti-bell me-1"></i> Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-connections.html"><i
                                class="ti-xs ti ti-link me-1"></i> Connections</a>
                    </li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @if (auth()->user()->profilepic)
                                {{-- <img src="" alt="Profile Picture"> --}}
                                <img src="{{ asset('storage/' . auth()->user()->profilepic) }}" alt="user-avatar"
                                    class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                            @else
                                <!-- Default image or placeholder if no profile picture is available -->
                                {{-- <img src="{{ asset('path-to-default-image.jpg') }}" alt="Default Profile Picture"> --}}
                                <img src="{{ asset('../../assets/img/avatars/14.png') }}" alt="user-avatar"
                                    class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                            @endif


                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="firstName" class="form-label">Full Name</label>
                                    <input class="form-control" value="{{ auth()->user()->name }}" type="text"
                                        id="firstName" name="name" value="John" autofocus />
                                </div>
                                {{-- <div class="mb-3 col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input class="form-control" type="text" name="lastName" id="lastName"
                                        value="Doe" />
                                </div> --}}
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" value="{{ auth()->user()->email }}" type="text"
                                        id="email" name="email" value="john.doe@example.com"
                                        placeholder="john.doe@example.com" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Organization</label>
                                    <input type="text"  value="{{ auth()->user()->organisation }}" class="form-control" id="organization" name="organisation"
                                        />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">US (+1)</span>
                                        <input type="text" id="phoneNumber" name="telphone" class="form-control"
                                            placeholder="202 555 0111" value="{{ auth()->user()->telphone }}" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" value="{{ auth()->user()->address }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <input class="form-control" type="text" id="state" name="state"
                                        placeholder="California" value="{{ auth()->user()->state }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zipCode" name="zipcode"
                                        placeholder="231465" maxlength="6" value="{{ auth()->user()->zipcode }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select id="country" class="select2 form-select" name="country">
                                        <option value="">Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}"
                                                {{ auth()->user()->country == $country ? 'selected' : '' }}>
                                                {{ $country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="language" class="form-label">Language</label>
                                    <select id="language" class="select2 form-select" name="language">
                                        <option value="">Select Language</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language }}" {{ auth()->user()->language == $language ? 'selected' : '' }}>
                                                {{ $language }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="timeZones" class="form-label">Timezone</label>
                                    <select id="timeZones" class="select2 form-select" name="timezone">
                                        <option value="">Select Timezone</option>
                                        @foreach($timezones as $timezone)
                                            <option value="{{ $timezone }}" {{ auth()->user()->timezone == $timezone ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="mb-3 col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select id="currency" class="select2 form-select" name="currency">
                                        <option value="">Select Currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency }}"
                                                {{ auth()->user()->currency == $currency ? 'selected' : '' }}>
                                                {{ $currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="mb-3 mt-3 col-md-6">
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="profilepic"
                                                class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                                </p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                    id="accountActivation" />
                                <label class="form-check-label" for="accountActivation">I confirm my account
                                    deactivation</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
