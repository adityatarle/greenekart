@extends('layouts.app')

@section('title', 'Dealer Registration - Greenleaf')

@section('content')
<div class="dealer-registration-page">
<div class="container-fluid dealer-reg-container">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11 col-xxl-10">
            <div class="dealer-reg-card">
                <div class="dealer-reg-body">
                    <div class="dealer-reg-header">
                        <h2>Dealer Registration</h2>
                        <p>Complete your dealer registration to access wholesale pricing</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show dealer-alert" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('dealer.register') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Business Information -->
                        <div class="dealer-section">
                            <h5 class="dealer-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Business Information
                            </h5>
                                
                                <div class="row g-4">
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="business_name" class="form-label">Business Name *</label>
                                        <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" value="{{ old('business_name') }}" required>
                                        @error('business_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="business_type" class="form-label">Business Type *</label>
                                        <select class="form-select @error('business_type') is-invalid @enderror" id="business_type" name="business_type" required>
                                            <option value="">Select Business Type</option>
                                            <option value="Individual" {{ old('business_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                                            <option value="Partnership" {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                            <option value="Company" {{ old('business_type') == 'Company' ? 'selected' : '' }}>Company</option>
                                            <option value="LLP" {{ old('business_type') == 'LLP' ? 'selected' : '' }}>LLP</option>
                                            <option value="HUF" {{ old('business_type') == 'HUF' ? 'selected' : '' }}>HUF</option>
                                        </select>
                                        @error('business_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="gst_number" class="form-label">GST Number</label>
                                        <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" value="{{ old('gst_number') }}" placeholder="22ABCDE1234F1Z5">
                                        <span class="form-hint">Format: 22ABCDE1234F1Z5 (Optional)</span>
                                        @error('gst_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="pan_number" class="form-label">PAN Number</label>
                                        <input type="text" class="form-control @error('pan_number') is-invalid @enderror" id="pan_number" name="pan_number" value="{{ old('pan_number') }}" placeholder="ABCDE1234F">
                                        <span class="form-hint">Format: ABCDE1234F (Optional)</span>
                                        @error('pan_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="business_address" class="form-label">Business Address *</label>
                                        <textarea class="form-control @error('business_address') is-invalid @enderror" id="business_address" name="business_address" rows="3" required>{{ old('business_address') }}</textarea>
                                        @error('business_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <label for="business_city" class="form-label">City *</label>
                                        <input type="text" class="form-control @error('business_city') is-invalid @enderror" id="business_city" name="business_city" value="{{ old('business_city') }}" required>
                                        @error('business_city')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <label for="business_state" class="form-label">State *</label>
                                        <input type="text" class="form-control @error('business_state') is-invalid @enderror" id="business_state" name="business_state" value="{{ old('business_state') }}" required>
                                        @error('business_state')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <label for="business_pincode" class="form-label">Pincode *</label>
                                        <input type="text" class="form-control @error('business_pincode') is-invalid @enderror" id="business_pincode" name="business_pincode" value="{{ old('business_pincode') }}" placeholder="123456" required>
                                        @error('business_pincode')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="dealer-section">
                            <h5 class="dealer-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Contact Information
                            </h5>
                                
                                <div class="row g-4">
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="contact_person" class="form-label">Contact Person *</label>
                                        <input type="text" 
                                               class="form-control @error('contact_person') is-invalid @enderror" 
                                               id="contact_person" 
                                               name="contact_person" 
                                               value="{{ old('contact_person') }}" 
                                               required>
                                        @error('contact_person')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="contact_email" class="form-label">Contact Email *</label>
                                        <input type="email" 
                                               class="form-control @error('contact_email') is-invalid @enderror" 
                                               id="contact_email" 
                                               name="contact_email" 
                                               value="{{ old('contact_email') }}" 
                                               required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="contact_phone" class="form-label">Contact Phone *</label>
                                        <input type="tel" 
                                               class="form-control @error('contact_phone') is-invalid @enderror" 
                                               id="contact_phone" 
                                               name="contact_phone" 
                                               value="{{ old('contact_phone') }}" 
                                               required>
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="alternate_phone" class="form-label">Alternate Phone</label>
                                        <input type="tel" 
                                               class="form-control @error('alternate_phone') is-invalid @enderror" 
                                               id="alternate_phone" 
                                               name="alternate_phone" 
                                               value="{{ old('alternate_phone') }}">
                                        @error('alternate_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="company_website" class="form-label">Company Website</label>
                                        <input type="url" 
                                               class="form-control @error('company_website') is-invalid @enderror" 
                                               id="company_website" 
                                               name="company_website" 
                                               value="{{ old('company_website') }}" 
                                               placeholder="https://www.example.com">
                                        @error('company_website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>

                        <!-- Business Details -->
                        <div class="dealer-section">
                            <h5 class="dealer-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                Business Details
                            </h5>
                                
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="business_description" class="form-label">Business Description</label>
                                        <textarea class="form-control @error('business_description') is-invalid @enderror" id="business_description" name="business_description" rows="4">{{ old('business_description') }}</textarea>
                                        <span class="form-hint">Describe your business, products, and experience in agriculture (Optional)</span>
                                        @error('business_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="years_in_business" class="form-label">Years in Business</label>
                                        <input type="number" 
                                               class="form-control @error('years_in_business') is-invalid @enderror" 
                                               id="years_in_business" 
                                               name="years_in_business" 
                                               value="{{ old('years_in_business') }}" 
                                               min="0" 
                                               max="100">
                                        @error('years_in_business')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <label for="annual_turnover" class="form-label">Annual Turnover</label>
                                        <select class="form-select @error('annual_turnover') is-invalid @enderror" 
                                                id="annual_turnover" 
                                                name="annual_turnover">
                                            <option value="">Select Annual Turnover</option>
                                            <option value="0-10L" {{ old('annual_turnover') == '0-10L' ? 'selected' : '' }}>0-10 Lakhs</option>
                                            <option value="10L-50L" {{ old('annual_turnover') == '10L-50L' ? 'selected' : '' }}>10-50 Lakhs</option>
                                            <option value="50L-1Cr" {{ old('annual_turnover') == '50L-1Cr' ? 'selected' : '' }}>50 Lakhs - 1 Crore</option>
                                            <option value="1Cr-5Cr" {{ old('annual_turnover') == '1Cr-5Cr' ? 'selected' : '' }}>1-5 Crores</option>
                                            <option value="5Cr+" {{ old('annual_turnover') == '5Cr+' ? 'selected' : '' }}>5+ Crores</option>
                                        </select>
                                        @error('annual_turnover')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>

                        <!-- Documents -->
                        <div class="dealer-section">
                            <h5 class="dealer-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                Business Documents (Optional)
                            </h5>
                                
                                <div class="row g-4">
                                    <div class="col-sm-6 col-lg-4">
                                        <label for="gst_certificate" class="form-label">GST Certificate</label>
                                        <input type="file" class="form-control @error('gst_certificate') is-invalid @enderror" id="gst_certificate" name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                        <span class="form-hint">PDF, JPG, PNG (Max 2MB)</span>
                                        @error('gst_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <label for="pan_certificate" class="form-label">PAN Certificate</label>
                                        <input type="file" class="form-control @error('pan_certificate') is-invalid @enderror" id="pan_certificate" name="pan_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                        <span class="form-hint">PDF, JPG, PNG (Max 2MB)</span>
                                        @error('pan_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <label for="business_license" class="form-label">Business License</label>
                                        <input type="file" class="form-control @error('business_license') is-invalid @enderror" id="business_license" name="business_license" accept=".pdf,.jpg,.jpeg,.png">
                                        <span class="form-hint">PDF, JPG, PNG (Max 2MB)</span>
                                        @error('business_license')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="dealer-section dealer-section-terms">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input @error('terms_accepted') is-invalid @enderror" 
                                           id="terms_accepted" 
                                           name="terms_accepted" 
                                           required>
                                    <label class="form-check-label" for="terms_accepted">
                                        I agree to the <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> 
                                        and <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a> *
                                    </label>
                                    @error('terms_accepted')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        </div>

                        <div class="dealer-submit-wrap">
                            <button type="submit" class="dealer-submit-btn">
                                Submit Registration
                            </button>
                        </div>
                    </form>

                    <p class="dealer-footer-note">Your registration will be reviewed by our team. You'll be notified once approved.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('styles')
<style>
.dealer-registration-page { background: #f8faf8; min-height: 100vh; padding: 32px 0 48px; }
.dealer-reg-container { max-width: 100%; padding-left: 24px; padding-right: 24px; }
@media (min-width: 1400px) {
    .dealer-reg-container { padding-left: 48px; padding-right: 48px; }
}
.dealer-reg-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); border: 1px solid #e8efe8; overflow: hidden; }
.dealer-reg-body { padding: 36px 40px; }
.dealer-reg-header { text-align: center; margin-bottom: 32px; }
.dealer-reg-header h2 { font-size: 1.6rem; font-weight: 700; color: #1a2e1a; margin: 0 0 8px 0; }
.dealer-reg-header p { font-size: 1rem; color: #666; margin: 0; }
.dealer-alert { margin-bottom: 24px; }
.dealer-section { background: #f8faf8; border-radius: 12px; padding: 28px 32px; margin-bottom: 24px; border: 1px solid #e8efe8; }
.dealer-section-title { display: flex; align-items: center; gap: 10px; font-size: 1.05rem; font-weight: 600; color: #1a2e1a; margin: 0 0 20px 0; }
.dealer-section-title svg { flex-shrink: 0; color: #6BB252; }
.dealer-section .row { --bs-gutter-x: 1.5rem; --bs-gutter-y: 1.5rem; }
.dealer-section .col-12, .dealer-section [class*="col-"] { min-width: 0; }
.dealer-section .form-label { display: block; font-size: 0.9rem; font-weight: 500; color: #333; margin-bottom: 8px; }
.dealer-section .form-control, .dealer-section .form-select { width: 100%; min-width: 0; padding: 12px 16px; font-size: 0.95rem; border: 1px solid #d0e0d0; border-radius: 8px; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box; }
.dealer-section .form-control:focus, .dealer-section .form-select:focus { outline: none; border-color: #6BB252; box-shadow: 0 0 0 3px rgba(107,178,82,0.15); }
.dealer-section .form-control.is-invalid { border-color: #dc3545; }
.dealer-section .form-hint { display: block; font-size: 0.75rem; color: #888; margin-top: 6px; }
.dealer-section textarea.form-control { resize: vertical; min-height: 100px; }
.dealer-section input[type="file"].form-control { padding: 10px 14px; font-size: 0.875rem; }
.dealer-section .invalid-feedback { font-size: 0.8rem; }
.dealer-section-terms { padding: 20px 32px; }
.dealer-section .form-check { margin: 0; }
.dealer-section .form-check-input { width: 1.15em; height: 1.15em; margin-top: 0.2em; }
.dealer-section .form-check-label { font-size: 0.9rem; margin-left: 10px; }
.dealer-section .form-check-label a { color: #6BB252; font-weight: 500; }
.dealer-submit-wrap { margin: 28px 0 20px 0; }
.dealer-submit-btn { width: 100%; padding: 16px 28px; background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%); color: #fff; border: none; border-radius: 10px; font-size: 1.05rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.dealer-submit-btn:hover { background: linear-gradient(135deg, #5a9a45 0%, #4a8a3a 100%); transform: translateY(-2px); box-shadow: 0 4px 16px rgba(107,178,82,0.35); color: #fff; }
.dealer-footer-note { text-align: center; font-size: 0.9rem; color: #888; margin: 0; }
@media (max-width: 991px) {
    .dealer-reg-body { padding: 28px 24px; }
    .dealer-section { padding: 22px 24px; margin-bottom: 20px; }
    .dealer-section .row { --bs-gutter-x: 1.25rem; --bs-gutter-y: 1.25rem; }
}
@media (max-width: 576px) {
    .dealer-registration-page { padding: 20px 0 32px; }
    .dealer-reg-container { padding-left: 16px; padding-right: 16px; }
    .dealer-reg-body { padding: 24px 20px; }
    .dealer-reg-header { margin-bottom: 24px; }
    .dealer-reg-header h2 { font-size: 1.4rem; }
    .dealer-section { padding: 20px 18px; margin-bottom: 18px; }
    .dealer-section .row { --bs-gutter-x: 1rem; --bs-gutter-y: 1rem; }
    .dealer-section .form-control, .dealer-section .form-select { padding: 11px 14px; }
}
</style>
@endpush
@endsection


















