
     <!-- ================= LOGIN VIEW ================= -->
    <div id="loginView" class="auth-view">
        <div class="login-wrapper">
            <!-- Left Panel — uses Drax's actual reference image directly
                 instead of a hand-coded CSS recreation, since the coded
                 version didn't match well enough. -->
            <div class="left-side">
                <img src="/images/login-left-panel.jpg" alt="REDFLOW — Connecting Blood Types, Sustaining the Flow of Life." class="left-side-image" onerror="this.onerror=null; this.style.display='none'; document.getElementById('leftSideFallbackMsg').style.display='flex';">
                <div id="leftSideFallbackMsg" style="display:none; position:absolute; inset:0; align-items:center; justify-content:center; text-align:center; color:#ffb3b3; font-family:var(--font-display); font-size:14px; padding:24px;">
                    Image failed to load.<br>Check that public/images/login-left-panel.jpg exists.
                </div>
            </div>
            <!-- Right Panel (Login Form) -->
            <div class="right-side">
                <div class="logo-container">
                    <svg class="blood-drop-logo" viewBox="0 0 24 24">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                        <path fill="#ffffff" d="M13 9h-2v3H8v2h3v3h2v-3h3v-2h-3z"/>
                    </svg>
                    <h2><span>RED</span>FLOW</h2>
                </div>
                <form class="login-form" onsubmit="event.preventDefault(); handleLogin();">
                    <div class="input-group-login">
                        <input type="email" id="loginEmail" placeholder="Email" required>
                    </div>
                    <div class="input-group-login">
                        <input type="password" id="loginPassword" placeholder="Password" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('loginPassword', this)">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>
                <div class="links-container">
                    <a class="forgot-password" onclick="openForgotPasswordModal()">Forgot Password</a>
                    <p class="signup-text">Don't have account? <span onclick="openSignupWizard()">Sign up</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FORGOT PASSWORD (email OTP recovery) ================= -->
    <div class="modal-overlay" id="forgotPasswordModal">
        <div class="modal-box signup-wizard-box">
            <button type="button" class="su-close-btn" onclick="closeForgotPasswordModal()"><i class="fa-solid fa-xmark"></i></button>

            <!-- FP STEP 1: ENTER EMAIL -->
            <div id="fp-step-1" class="su-step active">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Forgot Password?</div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="fpEmailInput" placeholder="Enter your registered email">
                </div>
                <p style="font-size:12px; color:#999; text-align:center; margin-bottom:6px;">A 6-digit verification code will be sent directly to your email address.</p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="closeForgotPasswordModal()">Cancel</button>
                    <button type="button" class="wizard-btn-next" id="fpSendCodeBtn" onclick="validateFpStep1()">Send Code</button>
                </div>
            </div>

            <!-- FP STEP 2: ENTER 6-DIGIT CODE -->
            <div id="fp-step-2" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Enter Verification Code</div>
                <p class="fp-otp-subtext" id="fpEmailTargetText">Check your email for the 6-digit code.</p>
                <div class="fp-otp-container">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                    <input type="text" maxlength="1" class="fp-otp-input fp-otp" inputmode="numeric">
                </div>
                <p class="fp-otp-subtext">Didn't receive the code? <span onclick="resendFpCode()">Resend</span></p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToFpStep(1)">Back</button>
                    <button type="button" class="wizard-btn-next" onclick="validateFpStep2()">Verify</button>
                </div>
            </div>

            <!-- FP STEP 3: RESET PASSWORD -->
            <div id="fp-step-3" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Reset Password</div>
                <div class="fp-password-rules">Must be at least 8 characters with numbers &amp; symbols</div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="fpNewPassword" placeholder="New Password">
                </div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="fpConfirmPassword" placeholder="Confirm Password">
                </div>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToFpStep(2)">Back</button>
                    <button type="button" class="wizard-btn-next" onclick="validateFpResetPassword()">Reset Password</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= STAFF SIGN UP WIZARD (multi-step, ID + Selfie verification) ================= -->
    <div class="modal-overlay" id="signupModal">
        <div class="modal-box signup-wizard-box">
            <button type="button" class="su-close-btn" onclick="closeSignupWizard()"><i class="fa-solid fa-xmark"></i></button>

            <!-- SU STEP 1: TERMS & PRIVACY -->
            <div id="su-step-1" class="su-step active">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Terms &amp; Privacy Policy</div>
                <div class="su-terms-box">
                    <h4>REDFLOW: A Community Blood Donation Blood Types Digital Master List in Irosin</h4>
                    <p>Welcome to the Community Blood Donation Blood Types Digital Master List in Irosin. These Terms and Conditions establish the rules, responsibilities, limitations, and proper use of the system. The system is designed as a digital information-management and coordination platform intended to help authorized personnel organize blood donor records, blood type information, and general location information in a centralized digital master list.</p>
                    <p>The system is intended to support the management and coordination of community blood donation information. It is not intended to replace hospitals, blood banks, healthcare professionals, laboratory procedures, medical screening, blood collection facilities, or official blood transfusion services.</p>
                    <p>By accessing or using the system, all authorized Staff and Administrators acknowledge that they have read, understood, and agreed to comply with these Terms and Conditions, the applicable institutional policies, and relevant laws and regulations of the Philippines.</p>
                    <h4>Purpose of the System</h4>
                    <p>The system provides an organized and accessible digital record of blood donor information. It may assist authorized personnel in managing donor records, identifying blood types, reviewing donor availability information, and locating potential donors based on their recorded general location.</p>
                    <p>The system serves only as an information and coordination tool. It does not independently determine whether an individual is medically qualified to donate blood, and it does not guarantee that a person listed in the system is currently available or eligible to donate.</p>
                    <h4>Authorized Use</h4>
                    <p>REDFLOW is intended only for authorized Staff and Administrators who have been given legitimate access by the organization or institution responsible for the system. Each user must use the system strictly for legitimate community blood donation coordination and administrative functions.</p>
                    <h4>Staff and Administrator Responsibilities</h4>
                    <p><strong>Staff Responsibilities:</strong> Handle donor information carefully, base entries on verified records, avoid outdated or duplicate entries, and strictly maintain data confidentiality.</p>
                    <p><strong>Administrator Responsibilities:</strong> Manage authorized access, oversee administrative controls, ensure system security, and handle sensitive data responsibly in compliance with organizational and privacy mandates.</p>
                    <h4>Accuracy of Information and Blood Types</h4>
                    <p>Information regarding donor names, blood types (ABO and Rh classifications), and general locations must be updated accurately. The system does not act as an independent medical authority; final compatibility determination, screening, and transfusion decisions remain solely with qualified healthcare professionals.</p>
                    <h4>Location Mapping</h4>
                    <p>Location-mapping features are meant to identify general geographic areas for coordination purposes. Location data must never be used to track, monitor, threaten, harass, or discriminate against any donor.</p>
                    <h4>Data Privacy (Republic Act No. 10173)</h4>
                    <p>The collection, storage, processing, and disposal of personal data strictly adhere to the Data Privacy Act of 2012 (RA 10173), upholding the principles of transparency, legitimate purpose, and proportionality.</p>
                    <h4>Medical Disclaimer</h4>
                    <p>REDFLOW is not a medical diagnosis or treatment system. Being listed as a donor does not automatically guarantee eligibility or current medical availability. Actual screening must always be performed through authorized medical facilities.</p>
                    <p style="margin-top:10px; font-size:11.5px;">See the full About Us page for the complete Terms and Conditions, Privacy Policy, and User Agreement.</p>
                </div>
                <div class="checkbox-row">
                    <input type="checkbox" id="suTermsConsent"> <label for="suTermsConsent">I have read and agree to the Terms and Conditions</label>
                </div>
                <div class="checkbox-row">
                    <input type="checkbox" id="suPrivacyConsent"> <label for="suPrivacyConsent">I consent to the Data Privacy Policy under RA 10173</label>
                </div>
                <p class="su-age-notice">By continuing, you confirm you are 18 years old and above.</p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="closeSignupWizard()">Decline</button>
                    <button type="button" class="wizard-btn-next" onclick="validateSuStep1()">Continue</button>
                </div>
            </div>

            <!-- SU STEP 2: PERSONAL INFORMATION -->
            <div id="su-step-2" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Enter Your Information</div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="suFullname" placeholder="First and Last Name">
                </div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" id="suContact" value="+63" placeholder="+639XXXXXXXXX" maxlength="13">
                </div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-calendar"></i>
                    <input type="date" id="suDob" title="Date of Birth">
                </div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-venus-mars"></i>
                    <select id="suGender">
                        <option value="" disabled selected>Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="wizard-input-group">
                    <i class="fa-solid fa-id-badge"></i>
                    <select id="suRole">
                        <option value="Staff" selected>Staff</option>
                    </select>
                </div>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToSignupStep(1)">BACK</button>
                    <button type="button" class="wizard-btn-next" onclick="validateSuStep2()">NEXT</button>
                </div>
            </div>

            <!-- SU STEP 3: LOCATION DETAILS -->
            <div id="su-step-3" class="su-step">
                <div class="su-step-title" style="color:#d32f2f;">Location Details</div>
                <div class="wizard-input-group">
                    <input type="text" value="Philippines" disabled style="background:var(--bg-light); color:var(--text-muted);">
                </div>
                <div class="wizard-input-group">
                    <input type="text" value="Bicol Region" disabled style="background:var(--bg-light); color:var(--text-muted);">
                </div>
                <div class="wizard-input-group">
                    <input type="text" value="Sorsogon" disabled style="background:var(--bg-light); color:var(--text-muted);">
                </div>
                <div class="wizard-input-group">
                    <input type="text" value="Irosin" disabled style="background:var(--bg-light); color:var(--text-muted);">
                </div>
                <div class="wizard-input-group">
                    <select id="suBrgy">
                        <option value="" disabled selected>Select Barangay</option>
                        <option value="Bacolod">Bacolod</option>
                        <option value="San Agustin">San Agustin</option>
                        <option value="San Juan">San Juan</option>
                        <option value="San Julian">San Julian</option>
                        <option value="San Pedro">San Pedro</option>
                        <option value="Bagsangan">Bagsangan</option>
                        <option value="Batang">Batang</option>
                        <option value="Bolos">Bolos</option>
                        <option value="Buenavista">Buenavista</option>
                        <option value="Bulawan">Bulawan</option>
                        <option value="Carriedo">Carriedo</option>
                        <option value="Casini">Casini</option>
                        <option value="Cawayan">Cawayan</option>
                        <option value="Cogon">Cogon</option>
                        <option value="Gabao">Gabao</option>
                        <option value="Gulang-Gulang">Gulang-Gulang</option>
                        <option value="Gumapia">Gumapia</option>
                        <option value="Liang">Liang</option>
                        <option value="Macawayan">Macawayan</option>
                        <option value="Mapaso">Mapaso</option>
                        <option value="Monbon">Monbon</option>
                        <option value="Patag">Patag</option>
                        <option value="Salvacion">Salvacion</option>
                        <option value="San Isidro">San Isidro</option>
                        <option value="Santo Domingo">Santo Domingo</option>
                        <option value="Tabon-Tabon">Tabon-Tabon</option>
                        <option value="Tinampo">Tinampo</option>
                        <option value="Tongdol">Tongdol</option>
                    </select>
                </div>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToSignupStep(2)">BACK</button>
                    <button type="button" class="wizard-btn-next" onclick="validateSuStep3()">NEXT</button>
                </div>
            </div>

            <!-- SU STEP 4: VALID ID VERIFICATION -->
            <div id="su-step-4" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Valid ID Verification</div>
                <input type="file" id="suIdFrontFile" accept="image/*" style="display:none;" onchange="handleSuIdUpload(this, 'front')">
                <div class="su-id-box" onclick="document.getElementById('suIdFrontFile').click()">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="su-id-label">Front of ID</div>
                    <div class="su-id-status" id="suIdFrontStatus">Tap to take photo or upload</div>
                    <img id="suIdFrontPreview" style="display:none;" alt="Front ID preview">
                </div>
                <input type="file" id="suIdBackFile" accept="image/*" style="display:none;" onchange="handleSuIdUpload(this, 'back')">
                <div class="su-id-box" onclick="document.getElementById('suIdBackFile').click()">
                    <i class="fa-solid fa-id-card"></i>
                    <div class="su-id-label">Back of ID</div>
                    <div class="su-id-status" id="suIdBackStatus">Tap to take photo or upload</div>
                    <img id="suIdBackPreview" style="display:none;" alt="Back ID preview">
                </div>
                <p style="font-size:11.5px; color:#999; text-align:center; margin-bottom:6px;">Place your ID card clearly in the frame. Ensure all details are readable.</p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToSignupStep(3)">BACK</button>
                    <button type="button" class="wizard-btn-next" onclick="validateSuStep4()">NEXT</button>
                </div>
            </div>

            <!-- SU STEP 5: SELFIE / FACE VERIFICATION -->
            <div id="su-step-5" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-subtitle">Verification &gt; Selfie Check</div>
                <div class="su-step-title" style="margin-bottom:12px;">Verification</div>
                <div class="su-selfie-frame">
                    <video id="suSelfieVideo" autoplay playsinline></video>
                    <canvas id="suSelfieCanvas" style="display:none;"></canvas>
                    <img id="suSelfiePreview" style="display:none;" alt="Captured Selfie">
                </div>
                <p style="font-size:12.5px; color:#666; text-align:center; margin-bottom:10px;" id="suSelfieInstruction">Hold phone still, look forward.</p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" id="suRetakeBtn" style="display:none;" onclick="retakeSuSelfie()">Retake</button>
                    <button type="button" class="wizard-btn-next" id="suSelfieActionBtn" onclick="captureSuSelfie()">Capture Photo</button>
                </div>
                <div style="display:flex; justify-content:center; align-items:center; gap:20px; margin-top:10px;">
                    <button type="button" class="wizard-btn-back" style="flex:none; padding:10px 14px; font-size:12px;" onclick="stopSuSelfieCamera(); goToSignupStep(4);">Back to ID</button>
                    <span class="su-skip-link" style="margin:0;" onclick="stopSuSelfieCamera(); goToSignupStep(6);">Skip</span>
                </div>
            </div>

            <!-- SU STEP 6: CREATE ACCOUNT -->
            <div id="su-step-6" class="su-step">
                <div class="su-brand"><span style="color:var(--primary-red);">RED</span>FLOW</div>
                <div class="su-step-title">Create Account</div>
                <div class="form-group-custom">
                    <label>Email Address</label>
                    <input type="email" id="suEmail" placeholder="halimbawa@gmail.com">
                </div>
                <div class="form-group-custom" style="position:relative;">
                    <label>Create Password</label>
                    <input type="password" id="suPassword" placeholder="Enter password">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('suPassword', this)" style="position:absolute; right:10px; top:30px; background:none; border:none; cursor:pointer; color:#999;"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                </div>
                <div class="form-group-custom" style="position:relative;">
                    <label>Confirm Password</label>
                    <input type="password" id="suConfirmPassword" placeholder="Re-enter password">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('suConfirmPassword', this)" style="position:absolute; right:10px; top:30px; background:none; border:none; cursor:pointer; color:#999;"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                </div>
                <p class="password-guide">Password must be at least 8 characters with numbers &amp; symbols.</p>
                <div class="wizard-btn-row">
                    <button type="button" class="wizard-btn-back" onclick="goToSignupStep(5)">BACK</button>
                    <button type="button" class="wizard-btn-next" onclick="validateSuStep6()">NEXT</button>
                </div>
            </div>

            <!-- SU STEP 7: SUMMARY PREVIEW -->
            <div id="su-step-7" class="su-step">
                <div class="su-step-title">Review Your Information</div>
                <input type="file" id="suAvatarFile" accept="image/*" style="display:none;" onchange="handleSuAvatarUpload(event)">
                <div class="su-summary-avatar" onclick="document.getElementById('suAvatarFile').click()" title="Click to change photo" style="cursor:pointer;">
                    <img id="suSummaryAvatar" src="picture.jpg" alt="Avatar preview" onerror="this.onerror=null;this.src='picture.jpg'">
                </div>
                <div style="text-align:center; font-size:12px; color:var(--primary-red); font-weight:bold; margin-bottom:15px; cursor:pointer;" onclick="document.getElementById('suAvatarFile').click()">
                    <i class="fa-solid fa-camera"></i> Click to change photo
                </div>
                <div class="form-group-custom">
                    <label>Full Name</label>
                    <input type="text" id="suSummaryFullname">
                </div>
                <div class="form-row-dual">
                    <div class="form-group-custom">
                        <label>Contact Number</label>
                        <input type="text" id="suSummaryContact">
                    </div>
                    <div class="form-group-custom">
                        <label>Sex</label>
                        <input type="text" id="suSummaryGender">
                    </div>
                </div>
                <div class="form-row-dual">
                    <div class="form-group-custom">
                        <label>Birthday</label>
                        <input type="text" id="suSummaryDob">
                    </div>
                    <div class="form-group-custom">
                        <label>Role</label>
                        <input type="text" id="suSummaryRole" readonly style="background:#e9ecef; color:#495057; cursor:not-allowed;">
                    </div>
                </div>
                <div class="form-group-custom">
                    <label>Barangay</label>
                    <input type="text" id="suSummaryBrgy">
                </div>
                <div class="form-group-custom">
                    <label>Email Address</label>
                    <input type="text" id="suSummaryEmail">
                </div>
                <button type="button" id="suSubmitApprovalBtn" class="action-main-btn" style="background:var(--primary-red);" onclick="confirmSuSignup()">Submit for Approval</button>
                <div class="wizard-btn-row" style="margin-top:10px;">
                    <button type="button" class="wizard-btn-back" onclick="goToSignupStep(6)">BACK</button>
                </div>
            </div>

            <!-- SU STEP 8: WAITING FOR ADMIN VERIFICATION -->
            <div id="su-step-8" class="su-step" style="text-align:center;">
                <div class="su-pending-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                <div class="su-step-title">Sign Up Submitted!</div>
                <p style="text-align:center; color:var(--text-muted); font-size:13.5px; margin-bottom:20px;">Your Staff account is now <strong>Pending</strong>. Please wait for an Admin to review and approve your ID and selfie verification before you can log in.</p>
                <button type="button" class="action-main-btn" style="background:var(--primary-red);" onclick="closeSignupWizard()">Back to Login</button>
            </div>
        </div>
    </div>


    <!-- ================= ADMIN STAFF APPROVAL MODAL ================= -->
    <div class="modal-overlay" id="staffApprovalModal">
        <div class="modal-box" style="width: 550px; text-align: left;">
            <h3 style="text-align: center; color: var(--primary-red);">PENDING STAFF APPROVALS</h3>
            <p style="text-align: center; margin-bottom: 15px;">Approve or reject Staff sign-up requests</p>
            
            <div id="pendingStaffList" style="max-height: 300px; overflow-y: auto; margin-bottom: 15px;">
                <!-- Dynamic pending staff items -->
            </div>

            <div style="text-align: right;">
                <button type="button" class="modal-btn btn-cancel" onclick="closeModal('staffApprovalModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- ================= IMAGE ZOOM MODAL ================= -->
    <div class="image-zoom-overlay" id="imageZoomOverlay" onclick="closeImageZoom()">
        <span class="image-zoom-close" onclick="closeImageZoom()">&times;</span>
        <img id="imageZoomTarget" src="" alt="Zoomed Document" onclick="event.stopPropagation()">
    </div>

    