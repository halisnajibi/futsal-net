@extends('layouts.admin')
@section('content')
    <div class="container-fluid">


        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pengaturan</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo rounded">
                            </div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="{{ asset('storage/'.Auth::user()->foto) }}" width="90" alt="" />
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0">{{ $profiel->nama }}</h4>
                                    <p>Member</p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0">{{ $profiel->email }}</h4>
                                    <p>Email</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session()->has('alert'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                class="me-2">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <strong>Berhasil!</strong> {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
         @endif
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link">Tentang Saya</a>
                                    </li>
                                    <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                                            class="nav-link">Password</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <form action="/profiel" method="post" enctype="multipart/form-data">
                                        @csrf
                                    <div id="about-me" class="tab-pane fade">
                                        <div class="profile-personal-info">
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Nama</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror()"
                                                        placeholder="nama" name="nama" value="{{ old('kode',$profiel->nama) }}">
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control wide" id="inlineFormCustomSelect"
                                                    name="jk">
                                                    @if ($profiel->jk == null)
                                                    <option value="laki-laki">Laki-Laki</option>
                                                    <option value="perempuan">Perempuan</option>
                                                    @elseif($profiel->jk == 'laki-laki')
                                                    <option value="laki-laki" selected>Laki-Laki</option>
                                                    <option value="perempuan">Perempuan</option>
                                                    @else
                                                    <option value="laki-laki" >Laki-Laki</option>
                                                    <option value="perempuan" selected>Perempuan</option>
                                                    @endif
                                                </select>
                                                </div>
                                            </div>
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('tempat_lahir') is-invalid @enderror()"
                                                        placeholder="tempat lahir" name="tempat_lahir" value="{{ old('tempat_lahir',$profiel->tempat_lahir) }}">
                                                    @error('tempat_lahir')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                                <div class="col-sm-9">
                                                    <input type="date"
                                                        class="form-control @error('tanggal_lahir') is-invalid @enderror()"
                                                        placeholder="tanggal lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir',$profiel->tanggal_lahir) }}">
                                                    @error('tanggal_lahir')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control @error('alamat') is-invalid @enderror()"
                                                        placeholder="alamat" name="alamat" value="{{ old('alamat',$profiel->alamat) }}">
                                                    @error('alamat')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="my-3 row">
                                                <label class="col-sm-3 col-form-label">Foto</label>
                                                <div class="col-sm-9">
                                                    <input type="file"
                                                        class="form-control @error('foto') is-invalid @enderror()"
                                                     name="foto">
                                                    @error('foto')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                                    <div id="profile-settings" class="tab-pane fade">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Account Setting</h4>
                                                <form>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" placeholder="Email"
                                                                class="form-control">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Password</label>
                                                            <input type="password" placeholder="Password"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" placeholder="1234 Main St"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Address 2</label>
                                                        <input type="text" placeholder="Apartment, studio, or floor"
                                                            class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">State</label>
                                                            <select class="form-control default-select wide"
                                                                id="inputState">
                                                                <option selected="">Choose...</option>
                                                                <option>Option 1</option>
                                                                <option>Option 2</option>
                                                                <option>Option 3</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            <label class="form-label">Zip</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check custom-checkbox">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="gridCheck">
                                                            <label class="form-check-label form-label" for="gridCheck">
                                                                Check me out</label>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Sign
                                                        in</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="replyModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Post Reply</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <textarea class="form-control" rows="4">Message</textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">btn-close</button>
                                            <button type="button" class="btn btn-primary">Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
