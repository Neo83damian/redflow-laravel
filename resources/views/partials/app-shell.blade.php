<!-- ================= MAIN APP CONTAINER ================= -->
    <div id="mainAppContainer" style="display: none; width: 100%; min-height: 100vh;">
        <!-- SIDEBAR NAVIGATION -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-top-content">
                <div class="sidebar-header">
                    <h1 class="logo-text"><span class="red-text">RED</span>FLOW</h1>
                    <p class="sub-logo-text">Blood Types<span class="red-text"> Digital MasterList</span></p>
                </div>
                
                <div class="sidebar-menu-buttons" id="sidebarMenuContainer">
                    <!-- Dynamically rendered sidebar menu buttons based on role (Admin vs Staff) -->
                </div>
            </div>
            <div class="sidebar-footer-action">
                <button class="btn-logout-side" onclick="openModal('logoutModal')"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </div>
        </nav>
        <!-- MAIN CONTENT WRAPPER -->
        <div id="main-content" class="main-content">
            
            <!-- TOP HEADER BAR -->
            <header class="top-bar">
                <button id="menu-btn" class="menu-btn" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                <div class="brand-top"><span class="red-text">RED</span>FLOW</div>
                <div class="top-profile-avatar" onclick="openStaffProfile()">
                    <img id="headerAvatarImg" src="picture.jpg" alt="Profile" onerror="this.onerror=null;this.src='picture.jpg'">
                </div>
            </header>
            <!-- HOME PAGE VIEW -->
            <section id="page-home" class="page-view active">
                <div class="search-filter-section-wrapper">
                    <div class="filter-section-header">
                        <h2>BLOOD TYPES DIGITAL MASTERLIST</h2>
                    </div>
                    
                    <div class="section-search-bar-row">
                        <div class="input-with-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="donor-search-input" placeholder="Search donor by blood type, name, or barangay..." oninput="debouncedFilterDonorsList()">
                        </div>
                    </div>
                    <div class="filter-controls-row">
                        <div class="dropdown-filter">
                            <button class="filter-drop-btn" onclick="toggleDropdown('abo-dropdown')"><i class="fa-solid fa-heart" style="color:var(--primary-red);"></i> ABO/Rh <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="dropdown-content" id="abo-dropdown">
                                <a href="#" onclick="filterByAbo('All'); return false;">All ABO/Rh</a>
                                <a href="#" onclick="filterByAbo('A+'); return false;">A+</a>
                                <a href="#" onclick="filterByAbo('A-'); return false;">A-</a>
                                <a href="#" onclick="filterByAbo('B+'); return false;">B+</a>
                                <a href="#" onclick="filterByAbo('B-'); return false;">B-</a>
                                <a href="#" onclick="filterByAbo('AB+'); return false;">AB+</a>
                                <a href="#" onclick="filterByAbo('AB-'); return false;">AB-</a>
                                <a href="#" onclick="filterByAbo('O+'); return false;">O+</a>
                                <a href="#" onclick="filterByAbo('O-'); return false;">O-</a>
                            </div>
                        </div>
                        <div class="dropdown-filter">
                            <button class="filter-drop-btn" onclick="toggleDropdown('brgy-dropdown')"><i class="fa-solid fa-location-dot" style="color:var(--primary-red);"></i> ALL Brgys. <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="dropdown-content scrollable-dropdown" id="brgy-dropdown">
                                <a href="#" onclick="filterByBrgy('All Brgys.'); return false;">All Brgys.</a>
                                <a href="#" onclick="filterByBrgy('Bacolod'); return false;">Bacolod</a>
                                <a href="#" onclick="filterByBrgy('San Agustin'); return false;">San Agustin</a>
                                <a href="#" onclick="filterByBrgy('San Juan'); return false;">San Juan</a>
                                <a href="#" onclick="filterByBrgy('San Julian'); return false;">San Julian</a>
                                <a href="#" onclick="filterByBrgy('San Pedro'); return false;">San Pedro</a>
                                <a href="#" onclick="filterByBrgy('Bagsangan'); return false;">Bagsangan</a>
                                <a href="#" onclick="filterByBrgy('Batang'); return false;">Batang</a>
                                <a href="#" onclick="filterByBrgy('Bolos'); return false;">Bolos</a>
                                <a href="#" onclick="filterByBrgy('Buenavista'); return false;">Buenavista</a>
                                <a href="#" onclick="filterByBrgy('Bulawan'); return false;">Bulawan</a>
                                <a href="#" onclick="filterByBrgy('Carriedo'); return false;">Carriedo</a>
                                <a href="#" onclick="filterByBrgy('Casini'); return false;">Casini</a>
                                <a href="#" onclick="filterByBrgy('Cawayan'); return false;">Cawayan</a>
                                <a href="#" onclick="filterByBrgy('Cogon'); return false;">Cogon</a>
                                <a href="#" onclick="filterByBrgy('Gabao'); return false;">Gabao</a>
                                <a href="#" onclick="filterByBrgy('Gulang-Gulang'); return false;">Gulang-Gulang</a>
                                <a href="#" onclick="filterByBrgy('Gumapia'); return false;">Gumapia</a>
                                <a href="#" onclick="filterByBrgy('Liang'); return false;">Liang</a>
                                <a href="#" onclick="filterByBrgy('Macawayan'); return false;">Macawayan</a>
                                <a href="#" onclick="filterByBrgy('Mapaso'); return false;">Mapaso</a>
                                <a href="#" onclick="filterByBrgy('Monbon'); return false;">Monbon</a>
                                <a href="#" onclick="filterByBrgy('Patag'); return false;">Patag</a>
                                <a href="#" onclick="filterByBrgy('Salvacion'); return false;">Salvacion</a>
                                <a href="#" onclick="filterByBrgy('San Isidro'); return false;">San Isidro</a>
                                <a href="#" onclick="filterByBrgy('Santo Domingo'); return false;">Santo Domingo</a>
                                <a href="#" onclick="filterByBrgy('Tabon-Tabon'); return false;">Tabon-Tabon</a>
                                <a href="#" onclick="filterByBrgy('Tinampo'); return false;">Tinampo</a>
                                <a href="#" onclick="filterByBrgy('Tongdol'); return false;">Tongdol</a>
                            </div>
                        </div>
                    </div>
                    <div id="donorBulkBar" class="admin-bulk-bar">
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); cursor:pointer;">
                            <input type="checkbox" class="admin-row-checkbox" id="donorSelectAll" onchange="toggleSelectAllDonors(this.checked)" style="margin-right:0;"> Select All
                        </label>
                        <button id="donorDeleteBtn" class="admin-bulk-delete-btn" onclick="deleteSelectedDonors()"><i class="fa-solid fa-trash"></i> DELETE (0)</button>
                    </div>
                </div>
                <div class="donor-count-label" id="donor-count-label">8 Donors List</div>
                <div class="donor-cards-container" id="donor-cards-wrapper">
                    <!-- Dynamic Donors Will Populate Here -->
                </div>
            </section>
            <!-- CREATE / EVENTS PAGE VIEW -->
            <section id="page-events" class="page-view">
                
                <!-- STEP 0: INITIAL CARD -->
                <div id="wizard-step-0" class="create-wizard-card">
                    <div style="display:flex; justify-content:center; margin-bottom:15px;">
                        <svg viewBox="0 0 24 24" width="45" height="55" fill="var(--primary-red)"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/><path fill="#ffffff" d="M13 9h-2v3H8v2h3v3h2v-3h3v-2h-3z"/></svg>
                    </div>
                    <h2>Create Digital Masterlist of Donors</h2>
                    <p>Create and manage the official digital masterlist of verified blood donors. Add donor information, blood type, location, contact details, availability, and verification status.</p>
                    <button class="wizard-main-btn" onclick="goToWizardStep(1)"><i class="fa-solid fa-user-plus"></i> ADD DONOR</button>
                </div>
                <!-- STEP 1: ENTER YOUR INFORMATION -->
                <div id="wizard-step-1" class="wizard-step-container">
                    <div class="wizard-inner-box">
                        <div style="color:var(--primary-red); font-weight:bold; font-size:18px; margin-bottom:2px;">REDFLOW</div>
                        <h3>Enter Your Information</h3>
                        <div class="wizard-subtitle">Personal Details</div>
                        
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="w_firstName" placeholder="First Name" required>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="w_middleName" placeholder="Middle Name">
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="w_noMiddle" onclick="toggleMiddleName(this)">
                            <label for="w_noMiddle">I have no Middle Name</label>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="w_lastName" placeholder="Last Name" required>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-user"></i>
                            <select id="w_ext">
                                <option value="">Ext.</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-calendar"></i>
                            <input type="date" id="w_bday" required>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" id="w_contact" value="+63" placeholder="+639XXXXXXXXX" maxlength="13" required>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-droplet" style="color:var(--primary-red);"></i>
                            <select id="w_bloodType" required>
                                <option value="" disabled selected>Blood Type</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        <div class="wizard-input-group">
                            <i class="fa-solid fa-users"></i>
                            <select id="w_role" required>
                                <option value="Donor" selected>Blood Donor</option>
                            </select>
                        </div>
                        <div class="wizard-btn-row">
                            <button class="wizard-btn-back" onclick="goToWizardStep(0)">BACK</button>
                            <button class="wizard-btn-next" onclick="validateStep1AndProceed()">NEXT</button>
                        </div>
                    </div>
                </div>
                <!-- STEP 2: LOCATION DETAILS -->
                <div id="wizard-step-2" class="wizard-step-container">
                    <div class="wizard-inner-box">
                        <h3 style="color:var(--primary-red); margin-bottom:15px;">Location Details</h3>
                        <div class="wizard-input-group">
                            <input type="text" value="Philippines" disabled style="background:var(--bg-light); color:var(--text-muted);">
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" value="Bicol Region" disabled style="background:var(--bg-light); color:var(--text-muted);">
                        </div>
                        <div class="wizard-input-group">
                            <select id="w_province" disabled style="background:var(--bg-light); color:var(--text-muted);">
                                <option selected>Sorsogon</option>
                            </select>
                        </div>
                        <div class="wizard-input-group">
                            <select id="w_municipality" disabled style="background:var(--bg-light); color:var(--text-muted);">
                                <option selected>Irosin</option>
                            </select>
                        </div>
                        <div class="wizard-input-group">
                            <select id="w_barangay" required>
                                <option value="" disabled selected>Barangay</option>
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
                        <div style="margin-top:20px; margin-bottom:10px; border-top:1px solid var(--border-color); padding-top:15px; text-align:left;">
                            <div style="font-weight:bold; color:var(--primary-red); font-size:14px; letter-spacing:0.5px; text-transform:uppercase;">Health &amp; Additional Information</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:3px;">For reference only. Final medical screening and eligibility must always be confirmed by authorized health personnel.</div>
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" id="w_weight" placeholder="Weight (kg)">
                        </div>
                        <div class="wizard-input-group">
                            <select id="w_eligibilityStatus">
                                <option value="Eligible" selected>Eligible</option>
                                <option value="Deferred">Deferred</option>
                                <option value="Under Review">Under Review</option>
                            </select>
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" id="w_allergies" placeholder="Known Allergies (if any)">
                        </div>
                        <div class="wizard-input-group" id="w_medicalConditions_wrap">
                            <input type="text" id="w_medicalConditions" placeholder="Existing Medical Conditions (if any)" oninput="autoSuggestEligibilityFromMedicalCondition(this.value, 'w_eligibilityStatus')">
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" id="w_deferralReason" placeholder="Deferral / Screening Notes (if any)">
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" id="w_emergencyContactName" placeholder="Emergency Contact Name">
                        </div>
                        <div class="wizard-input-group">
                            <input type="text" id="w_emergencyContactNumber" placeholder="Emergency Contact Number">
                        </div>

                        <div class="wizard-btn-row">
                            <button class="wizard-btn-back" onclick="goToWizardStep(1)">BACK</button>
                            <button class="wizard-btn-next" onclick="validateStep2AndProceed()">NEXT</button>
                        </div>
                    </div>
                </div>
               
                <!-- STEP 4: FINAL REVIEW & CREATE -->
                <div id="wizard-step-4" class="wizard-step-container">
                    <div class="wizard-inner-box" style="text-align:left;">
                        <input type="file" id="wizardAvatarFile" accept="image/*" style="display:none;" onchange="handleWizardAvatarUpload(event)">
                        <div class="profile-upload-circle" onclick="document.getElementById('wizardAvatarFile').click()">
                            <img id="wizardAvatarPreview" src="picture.jpg" alt="Avatar" onerror="this.onerror=null;this.src='picture.jpg'">
                        </div>
                        <div style="text-align:center; font-size:12px; color:var(--primary-red); font-weight:bold; margin-bottom:20px; cursor:pointer;" onclick="document.getElementById('wizardAvatarFile').click()">
                            <i class="fa-solid fa-camera"></i> Click to change photo
                        </div>
                        <div style="display:flex; gap:15px;">
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">First Name</label>
                                <input type="text" id="rev_firstName">
                            </div>
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Middle Name</label>
                                <input type="text" id="rev_middleName">
                            </div>
                        </div>
                        <div style="display:flex; gap:15px;">
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Surname</label>
                                <input type="text" id="rev_lastName">
                            </div>
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Blood Type</label>
                                <input type="text" id="rev_bloodType">
                            </div>
                        </div>
                        <div style="display:flex; gap:15px;">
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Ext.</label>
                                <input type="text" id="rev_ext">
                            </div>
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Birthday</label>
                                <input type="text" id="rev_bday">
                            </div>
                        </div>
                        <div style="display:flex; gap:15px;">
                            <div class="form-group-custom" style="flex:1;">
                                <label style="font-size:10px;">Sex</label>
                                <input type="text" value="Male">
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label style="font-size:10px;">Contact Number</label>
                            <input type="text" id="rev_contact">
                        </div>
                        <div class="form-group-custom">
                            <label style="font-size:10px;">Location</label>
                            <input type="text" id="rev_location">
                        </div>
                        <button class="action-main-btn" style="background:#990000; margin-top:15px;" onclick="commitNewDonor()">CREATE</button>
                    </div>
                </div>
            </section>
            <!-- RECORD / HISTORY PAGE VIEW -->
            <section id="page-history" class="page-view">
                <div style="background:var(--card-bg); padding:20px; border-radius:8px;">
                    <div style="font-size: 24px; font-weight: bold; color: var(--text-dark); margin-bottom: 15px; text-align: center;">History Records</div>
                    
                    <!-- Search Bar for History Records -->
                    <div class="section-search-bar-row" style="margin-bottom: 20px;">
                        <div class="input-with-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="history-search-input" placeholder="Search history records by name or blood type..." oninput="debouncedFilterHistoryRecords()">
                        </div>
                    </div>
                    <div id="historyBulkBar" class="admin-bulk-bar">
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); cursor:pointer;">
                            <input type="checkbox" class="admin-row-checkbox" id="historySelectAll" onchange="toggleSelectAllRecords(this.checked)" style="margin-right:0;"> Select All
                        </label>
                        <button id="historyDeleteBtn" class="admin-bulk-delete-btn" onclick="deleteSelectedRecords()"><i class="fa-solid fa-trash"></i> DELETE (0)</button>
                    </div>
                    <div id="monitoring-table-container" style="display:flex; flex-direction:column; gap:15px;">
                        <!-- Dynamic History Records Populated Here -->
                    </div>
                </div>
            </section>
            <!-- STATISTICS DASHBOARD PAGE VIEW -->
            <section id="page-statistics" class="page-view">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:20px;">
                    <div class="stat-summary-card" style="border-left-color:var(--warning-orange);">
                        <div class="stat-summary-label">Number of Pending Staff</div>
                        <div id="statTotalPending" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--primary-blue);">
                        <div class="stat-summary-label">Number of Admin</div>
                        <div id="statNumberAdmin" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--primary-red);">
                        <div class="stat-summary-label">Number of Staff</div>
                        <div id="statNumberStaff" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--success-green);">
                        <div class="stat-summary-label">Number of Donors</div>
                        <div id="statNumberDonors" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--primary-red);">
                        <div class="stat-summary-label">Number of History</div>
                        <div id="statNumberHistory" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--primary-blue);">
                        <div class="stat-summary-label">Number of Notification</div>
                        <div id="statNumberNotifications" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--warning-orange);">
                        <div class="stat-summary-label">Number of Audit Log</div>
                        <div id="statNumberAuditLog" class="stat-summary-value">0</div>
                    </div>
                    <div class="stat-summary-card" style="border-left-color:var(--success-green);">
                        <div class="stat-summary-label">Number of User Log</div>
                        <div id="statNumberUserLog" class="stat-summary-value">0</div>
                    </div>
                </div>
                <div class="stats-panels-row">
                    <div class="stats-panel-box">
                        <div class="stats-panel-header">
                            <h3><i class="fa-solid fa-chart-column" style="color:var(--primary-red); margin-right:6px;"></i>Monthly Donations</h3>
                            <input type="date" id="monthlyDonationsDate" class="stats-date-input" onchange="updateStatisticsData()">
                        </div>
                        <div class="monthly-chart-wrap" id="monthlyDonationsChart"></div>
                        <div class="monthly-chart-labels" id="monthlyDonationsLabels"></div>
                    </div>
                    <div class="stats-panel-box">
                        <div class="stats-panel-header">
                            <h3><i class="fa-solid fa-droplet" style="color:var(--primary-red); margin-right:6px;"></i>Blood Type Availability</h3>
                        </div>
                        <div id="bloodTypeAvailabilityList"></div>
                    </div>
                </div>
            </section>
            <!-- APPROVAL VERIFICATION PAGE VIEW -->
            <section id="page-approvals" class="page-view">
                <div style="background:var(--card-bg); padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border:1px solid var(--border-color);">
                    <h2 style="color:var(--primary-red); margin-bottom:15px; text-align:center;"><i class="fa-solid fa-user-check"></i> Approval Verification</h2>
                    <p style="text-align:center; color:var(--text-muted); margin-bottom:20px; font-size:14px;">Approve or reject Staff Account sign-up requests.</p>
                    <div id="adminApprovalPageViewList" class="approval-table-wrapper">
                        <!-- Dynamic Admin Approval List -->
                    </div>
                </div>
            </section>
            <!-- USERS LOG PAGE VIEW -->
            <section id="page-userslog" class="page-view">
                <div style="background:var(--card-bg); padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border:1px solid var(--border-color);">
                    <h2 style="color:var(--primary-red); margin-bottom:15px; text-align:center;"><i class="fa-solid fa-users-rectangle"></i> Users Log</h2>
                    <p style="text-align:center; color:var(--text-muted); margin-bottom:20px; font-size:14px;">List of all registered Staff and Admin accounts in the system.</p>
                    <div id="usersBulkBar" class="admin-bulk-bar">
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); cursor:pointer;">
                            <input type="checkbox" class="admin-row-checkbox" id="usersSelectAll" onchange="toggleSelectAllUsers(this.checked)" style="margin-right:0;"> Select All
                        </label>
                        <button id="usersDeleteBtn" class="admin-bulk-delete-btn" onclick="deleteSelectedUsers()"><i class="fa-solid fa-trash"></i> DELETE (0)</button>
                    </div>
                    <div id="usersLogContainer" style="display:flex; flex-direction:column; gap:12px;">
                        <!-- Dynamic Users Log -->
                    </div>
                </div>
            </section>
            <!-- AUDIT TRAIL / SENSITIVE DATA ACCESS LOG PAGE VIEW (RA 10173 compliance) -->
            <section id="page-auditlog" class="page-view">
                <div style="background:var(--card-bg); padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border:1px solid var(--border-color);">
                    <h2 style="color:var(--primary-red); margin-bottom:15px; text-align:center;"><i class="fa-solid fa-shield-halved"></i> Audit Log</h2>
                    <p style="text-align:center; color:var(--text-muted); margin-bottom:20px; font-size:14px;">Record every Change, Create, Update, Delete, and Export, of donor records and masterlists.</p>
                    <div class="admin-bulk-bar" id="auditLogBulkBar" style="justify-content:space-between;">
                        <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); cursor:pointer;">
                            <input type="checkbox" class="admin-row-checkbox" id="auditLogSelectAll" onchange="toggleSelectAllAuditLog(this.checked)" style="margin-right:0;"> Select All
                        </label>
                        <div style="display:flex; gap:10px; flex-wrap:wrap;">
                            <button id="auditLogDeleteBtn" class="admin-bulk-delete-btn" onclick="deleteSelectedAuditLogEntries()"><i class="fa-solid fa-trash"></i> DELETE (0)</button>
                        </div>
                    </div>
                    <div id="auditLogContainer" style="display:flex; flex-direction:column; gap:12px;">
                        <!-- Dynamic Audit Log -->
                    </div>
                </div>
            </section>
            <!-- SETTINGS / ACCOUNT SECURITY PAGE VIEW -->
            <section id="page-settings" class="page-view">
                <div class="change-pass-container">
                    <h2>Change Password</h2>
                    <div class="password-guide">Password must be at least 8 characters with numbers & symbols.</div>
                    <form onsubmit="event.preventDefault(); validateAndChangePassword();">
                        <div class="form-group-custom">
                            <label>Current Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="currentPassInput" placeholder="Enter Current Password" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('currentPassInput', this)"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label>New Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="newPassInput" placeholder="Enter New Password" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassInput', this)"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label>Confirm New Password</label>
                            <div class="password-input-wrap">
                                <input type="password" id="confirmPassInput" placeholder="Confirm New Password" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassInput', this)"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                            </div>
                        </div>
                        <button type="submit" class="action-main-btn">Update Password</button>
                    </form>
                </div>
            </section>
            <!-- DONOR / ACCOUNT PROFILE VIEW -->
            <section id="page-profile" class="page-view">
                <div class="profile-container" id="profile-container-box">
                    <!-- Dynamically injected profile content based on whether it's Staff/Admin or Donor -->
                </div>
            </section>
            <!-- CREATE DONOR HISTORY RECORD FORM VIEW -->
            <section id="page-create-history-form" class="page-view">
                <div style="background:var(--card-bg); border-radius:12px; padding:30px; max-width:600px; margin:20px auto; box-shadow:0 4px 15px rgba(0,0,0,0.08); border:1px solid var(--border-color);">
                    <div style="color:var(--primary-red); font-size:22px; font-weight:bold; text-align:center; margin-bottom:25px; text-transform:uppercase; letter-spacing:0.5px;">Create Donor History Record</div>
                    <input type="hidden" id="history_form_donorId" value="">

                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Donor's Name:</label>
                        <input type="text" id="history_form_name" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Location:</label>
                        <input type="text" id="history_form_location" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Blood Type:</label>
                        <select id="history_form_bloodType" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">New Donation:</label>
                        <input type="date" id="history_form_newDonation" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Last Donation:</label>
                        <input type="date" id="history_form_lastDonation" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Times Donated:</label>
                        <input type="text" id="history_form_times" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:16px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Amounts:</label>
                        <input type="text" id="history_form_amount" value="1 unit" style="width:100%; padding:12px; border:1px solid var(--border-color); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 150px 1fr; gap:15px; align-items:center; margin-bottom:25px;">
                        <label style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px; text-transform:uppercase;">Status:</label>
                        <select id="history_form_status" onchange="updateHistoryStatusColor(this)" style="width:100%; padding:12px; border:1px solid var(--warning-orange); border-radius:6px; font-size:15px; font-weight:bold; outline:none; background:var(--warning-orange); color:#222; text-align:center;">
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                        </select>
                    </div>

                    <div style="display:flex; gap:15px;">
                        <button onclick="switchMainPage('profile', null)" style="flex:1; padding:14px; background-color:var(--primary-red); color:white; border:none; border-radius:6px; font-size:16px; font-weight:bold; cursor:pointer;">Cancel</button>
                        <button onclick="approveAndCommitHistoryRecord()" style="flex:1; padding:14px; background-color:var(--primary-blue); color:white; border:none; border-radius:6px; font-size:16px; font-weight:bold; cursor:pointer;">Approve</button>
                    </div>
                </div>
            </section>
            <!-- SINGLE RECORD DETAIL VIEW -->
            <section id="page-single-record" class="page-view">
                <div style="background:var(--card-bg); border-radius:12px; padding:30px; max-width:700px; margin:20px auto; box-shadow:0 4px 15px rgba(0,0,0,0.08); border:1px solid var(--border-color);">
                    <div style="background:#000; color:#fff; padding:15px; text-align:center; font-size:18px; font-weight:bold; border-radius:6px; margin-bottom:25px;">Donation History Record</div>

                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">DONOR'S NAME:</div>
                        <div id="detail_name" style="font-weight:bold;">Maria Balon Santos</div>
                        <input id="detail_name_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">LOCATION:</div>
                        <div id="detail_location" style="font-weight:bold;">N/A</div>
                        <input id="detail_location_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">BLOOD TYPE:</div>
                        <div id="detail_bloodType" style="font-weight:bold;">A+</div>
                        <select id="detail_bloodType_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                        </select>
                        <div id="detail_bloodType_lock_note" style="display:none; font-size:10px; color:var(--text-muted); margin-top:3px;"><i class="fa-solid fa-lock"></i> Locked — only an Admin can edit Blood Type once set.</div>
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">NEW DONATION:</div>
                        <div id="detail_newDonation">August 18, 2026</div>
                        <input type="date" id="detail_newDonation_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">LAST DONATION:</div>
                        <div id="detail_lastDonation">N/A</div>
                        <input type="date" id="detail_lastDonation_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">TIMES DONATED:</div>
                        <div id="detail_timesDonated">1</div>
                        <input type="number" min="1" id="detail_timesDonated_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:15px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">AMOUNTS:</div>
                        <div id="detail_amount">1 unit</div>
                        <input id="detail_amount_edit" style="display:none; width:100%; padding:10px; border:1px solid var(--border-color); border-radius:6px; font-size:14px; font-weight:bold; background:var(--input-bg); color:var(--text-dark);">
                    </div>
                    <div style="display:grid; grid-template-columns: 180px 1fr; gap:15px; align-items:center; margin-bottom:25px; font-size:14px; color:var(--text-dark); border-bottom:1px solid var(--border-color); padding-bottom:12px;">
                        <div style="font-weight:bold; color:var(--text-muted); font-size:12px; letter-spacing:0.5px;">CREATED BY:</div>
                        <div id="detail_createdBy">Unknown</div>
                    </div>

                    <div id="recordViewButtons">
                        <button onclick="enterRecordEditMode()" style="width:100%; padding:14px; background-color:#222; color:white; border:none; border-radius:6px; font-size:15px; font-weight:bold; cursor:pointer; margin-bottom:10px;"><i class="fa-solid fa-pen"></i> Edit Record</button>
                        <button onclick="switchMainPage('history', document.querySelectorAll('.bottom-nav-item')[2])" style="width:100%; padding:14px; background-color:var(--primary-blue); color:white; border:none; border-radius:6px; font-size:15px; font-weight:bold; cursor:pointer;"><i class="fa-solid fa-arrow-left"></i> Back to History Records</button>
                    </div>
                    <div id="recordEditButtons" style="display:none; gap:12px;">
                        <button onclick="cancelRecordEditMode()" style="flex:1; padding:14px; background-color:var(--primary-red); color:white; border:none; border-radius:6px; font-size:15px; font-weight:bold; cursor:pointer;">Cancel</button>
                        <button onclick="saveRecordEdit()" style="flex:1; padding:14px; background-color:var(--primary-blue); color:white; border:none; border-radius:6px; font-size:15px; font-weight:bold; cursor:pointer;">Save Changes</button>
                    </div>
                </div>
                <!-- LAST DONATION TRANSACTION LIST - FULL DONATION HISTORY FOR THIS DONOR -->
                <div style="background:var(--card-bg); border-radius:12px; padding:25px 30px; max-width:700px; margin:20px auto; box-shadow:0 4px 15px rgba(0,0,0,0.08); border:1px solid var(--border-color);">
                    <div style="border:2px solid var(--text-dark); border-radius:6px; padding:14px; text-align:center; font-size:17px; font-weight:bold; letter-spacing:0.5px; margin-bottom:10px; color:var(--text-dark);">LAST DONATION TRANSACTION</div>
                    <div id="lastDonationTransactionList"></div>
                </div>
            </section>
            <!-- ABOUT US PAGE VIEW -->
            <section id="page-about" class="page-view">
                <div class="about-tabs">
                    <button class="about-tab-btn active" id="aboutTabBtn" onclick="loadSubModule('about')"><i class="fa-solid fa-circle-info"></i> About Us</button>
                    <button class="about-tab-btn" id="faqTabBtn" onclick="loadSubModule('faq')"><i class="fa-solid fa-circle-question"></i> FAQ</button>
                </div>
                <div id="aboutSubPanel" class="about-subpanel active">
                    <div class="about-card">
<p class="about-hero">REDFLOW: A COMMUNITY BLOOD DONATION BLOOD TYPES DIGITAL MASTER LIST IN IROSIN</p>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> About REDFLOW</h3>
<p>REDFLOW: A Community Blood Donation Blood Types Digital Master List in Irosin is a digital information and coordination system designed to support the organized management of voluntary blood donor information within the Municipality of Irosin. The system is intended to help authorized personnel maintain a centralized and organized digital master list containing relevant donor information, particularly blood type and location-related information that may assist in identifying potential donors when a legitimate blood donation need arises.</p>
<p>The primary purpose of REDFLOW is to improve the organization, accessibility, and management of blood donor information. Instead of relying entirely on handwritten records, scattered documents, or manually maintained lists, REDFLOW provides an organized digital environment where authorized users can manage donor records more efficiently.</p>
<p>REDFLOW is designed as a support and information-management system. It does not function as a blood bank, blood collection center, laboratory, hospital, or medical facility. It does not collect, store, test, process, transport, sell, or transfuse blood. It also does not independently determine whether a person is medically qualified to donate blood. Medical screening, blood typing confirmation, compatibility testing, donor eligibility assessment, blood collection, storage, and transfusion remain the responsibility of qualified healthcare professionals and authorized blood-service facilities.</p>
<p>The system may assist authorized personnel in locating or identifying potentially suitable registered donors based on information available in the master list. Any final decision concerning donor eligibility, blood compatibility, medical suitability, or actual blood donation must be verified by authorized healthcare personnel.</p>
<p>The scope of REDFLOW is intended to focus on the community of Irosin. The system may contain information such as a donor's name or identification reference, blood type, contact information where legitimately required, location or barangay, availability status, verification status, and other information necessary for the declared purpose of the system. Only information that is necessary and appropriate for the stated purpose should be collected.</p>
<p>REDFLOW seeks to support voluntary blood donation and community coordination while respecting the privacy, dignity, safety, and rights of every person whose information is included in the system.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Our Purpose</h3>
<p>REDFLOW is intended to provide an organized digital master list that can help authorized personnel:</p>
<ul class="about-list">
  <li>Maintain an organized record of registered and verified potential blood donors.</li>
  <li>Search donor records using appropriate blood-type information.</li>
  <li>Identify potential donors within the intended service area.</li>
  <li>Manage donor availability and verification status.</li>
  <li>Reduce duplication and confusion in manually maintained donor records.</li>
  <li>Support faster coordination between authorized personnel and potential donors.</li>
  <li>Maintain appropriate records for administrative and community blood-donation coordination.</li>
  <li>Promote awareness of voluntary blood donation.</li>
  <li>Support authorized healthcare personnel without replacing their professional judgment.</li>
</ul>
<p>The system is not intended to guarantee that a listed donor will be available, medically eligible, or compatible at the time of an actual blood-donation request.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Legal and Policy Basis</h3>
<p>REDFLOW recognizes the importance of complying with applicable Philippine laws, regulations, institutional policies, and ethical requirements.</p>
<h4 class="about-h3">Republic Act No. 10173 — Data Privacy Act of 2012</h4>
<p>Republic Act No. 10173, also known as the Data Privacy Act of 2012, protects individual personal information and establishes rules for the lawful processing of personal data. The law requires personal information processing to observe the principles of transparency, legitimate purpose, and proportionality. It also provides rules concerning lawful processing, sensitive personal information, security, accountability, and the rights of data subjects.</p>
<p>Because REDFLOW may process information relating to a person's health or blood type, the system must treat such information with appropriate care and safeguards. The Data Privacy Act identifies information about an individual's health as sensitive personal information, subject to the applicable requirements of the law.</p>
<p>REDFLOW therefore commits to collecting and processing information only for declared and legitimate purposes and only to the extent reasonably necessary for those purposes.</p>
<h4 class="about-h3">Republic Act No. 7719 — National Blood Services Act of 1994</h4>
<p>Republic Act No. 7719, also known as the National Blood Services Act of 1994, promotes voluntary blood donation and provides a legal framework for maintaining an adequate and safe blood supply. It recognizes voluntary blood donation as a humanitarian act and establishes standards concerning blood banks, blood collection units, and blood-related services.</p>
<p>REDFLOW supports the general objective of encouraging voluntary blood donation, but it does not replace the medical and regulatory functions established under RA 7719. Blood collection and related clinical procedures must be performed by authorized facilities and qualified personnel.</p>
<h4 class="about-h3">Republic Act No. 10173 and the Data Privacy Principles</h4>
<p>The Implementing Rules and Regulations of RA 10173 emphasize transparency, legitimate purpose, and proportionality. They also require that personal data be collected for a declared, specified, and legitimate purpose and that unnecessary or excessive information not be collected.</p>
<p>REDFLOW applies these principles to its donor master list and administrative processes.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Privacy Policy</h3>
<h4 class="about-h3">Privacy Commitment</h4>
<p>REDFLOW respects the privacy of individuals whose information is collected, recorded, stored, or processed through the system. Personal information shall not be collected merely because it is technically possible to collect it. Information must have a clear connection to the legitimate purpose of REDFLOW.</p>
<p>The system shall implement reasonable organizational, physical, and technical safeguards appropriate to the nature of the information being processed.</p>
<h4 class="about-h3">Information We May Collect</h4>
<p>Depending on the approved system design and legitimate operational requirements, REDFLOW may process information such as:</p>
<ul class="about-list">
  <li>Full name or authorized identification information.</li>
  <li>Blood type.</li>
  <li>Barangay or general location.</li>
  <li>Contact information when necessary for legitimate coordination.</li>
  <li>Donor availability status.</li>
  <li>Donor verification status.</li>
  <li>Donation-related administrative information.</li>
  <li>Account credentials required for authorized system access.</li>
  <li>System activity or audit information.</li>
  <li>Other information specifically approved as necessary for the project.</li>
</ul>
<p>REDFLOW should avoid collecting information that is unnecessary for its declared purpose.</p>
<h4 class="about-h3">Blood Type and Health-Related Information</h4>
<p>Blood type and other health-related information must be handled carefully. REDFLOW does not independently verify medical eligibility unless such verification is performed by authorized healthcare personnel.</p>
<p>A blood type appearing in the digital master list should not automatically be treated as a final medical determination for transfusion purposes. Healthcare professionals must perform the appropriate verification and clinical procedures before blood donation or transfusion.</p>
<h4 class="about-h3">Purpose of Data Processing</h4>
<p>Information may be processed for legitimate purposes such as:</p>
<ul class="about-list">
  <li>Maintaining the donor master list.</li>
  <li>Identifying potential donors.</li>
  <li>Managing donor records.</li>
  <li>Supporting authorized blood-donation coordination.</li>
  <li>Confirming registration or verification status.</li>
  <li>Communicating legitimate donation-related information.</li>
  <li>Generating administrative reports.</li>
  <li>Improving the organization and management of the system.</li>
  <li>Meeting applicable legal, institutional, or research requirements.</li>
</ul>
<p>Personal information shall not be processed for unrelated purposes without an appropriate lawful basis.</p>
<h4 class="about-h3">Transparency</h4>
<p>Users and data subjects should be informed about what information is collected, why it is collected, how it is used, who may access it, how long it may be retained, and how they may exercise their applicable rights.</p>
<p>The information provided through the privacy notice should be understandable and accessible. The NPC's own privacy policy similarly emphasizes explaining the nature and purpose of processing and following transparency, legitimate purpose, and proportionality.</p>
<h4 class="about-h3">Data Minimization</h4>
<p>REDFLOW shall follow the principle that only information reasonably necessary for the declared purpose should be collected.</p>
<p>The system should not collect unnecessary personal information simply for convenience or future use.</p>
<h4 class="about-h3">Data Accuracy</h4>
<p>Reasonable measures should be taken to maintain accurate and updated records. If a donor's information changes, authorized personnel should have an appropriate process for correcting or updating the record.</p>
<p>Incorrect or outdated information should not knowingly be used when it could affect legitimate blood-donation coordination.</p>
<h4 class="about-h3">Data Security</h4>
<p>REDFLOW shall implement appropriate safeguards, which may include:</p>
<ul class="about-list">
  <li>Authorized account access.</li>
  <li>Password protection.</li>
  <li>Role-based access.</li>
  <li>Administrative controls.</li>
  <li>Secure database management.</li>
  <li>Audit logs where appropriate.</li>
  <li>Restricted access to sensitive records.</li>
  <li>Secure handling of uploaded documents.</li>
  <li>Regular review of user permissions.</li>
  <li>Secure deletion or disposal when retention is no longer necessary.</li>
</ul>
<p>Security measures should be appropriate to the risks associated with the information processed.</p>
<h4 class="about-h3">Access to Information</h4>
<p>Access to donor information shall be limited to authorized users whose responsibilities require access to the information.</p>
<p>Not every user should automatically have access to the complete donor master list.</p>
<p>For example, an administrator may have broader management privileges, while another authorized staff member may have access only to information necessary for his or her assigned task.</p>
<h4 class="about-h3">Disclosure of Information</h4>
<p>REDFLOW shall not disclose personal information to unauthorized individuals.</p>
<p>Information may only be disclosed when there is an appropriate lawful basis, authorization, legitimate operational need, or legal requirement.</p>
<p>Where information must be shared with another organization or authorized third party, appropriate privacy and security safeguards should be established.</p>
<p>The Data Privacy Act places accountability on the personal information controller for information under its control, including information transferred to third parties for processing.</p>
<h4 class="about-h3">Data Retention</h4>
<p>Personal information should not be retained indefinitely merely because it has already been collected.</p>
<p>Records should be retained only for as long as necessary for the declared purpose, applicable legal requirements, approved research requirements, institutional policies, or legitimate claims.</p>
<p>When retention is no longer necessary, information should be securely deleted, destroyed, anonymized, or otherwise disposed of according to the approved data-retention and disposition procedure.</p>
<h4 class="about-h3">Data Breach and Security Incident</h4>
<p>If a suspected unauthorized access, disclosure, loss, alteration, or other security incident occurs, the responsible personnel should follow the organization's approved incident-response procedure.</p>
<p>The incident should be documented, assessed, contained, and addressed according to applicable law, institutional policy, and Data Privacy Act requirements.</p>
<h4 class="about-h3">Data Subject Rights</h4>
<p>Subject to applicable law and limitations, data subjects may have rights concerning their personal information, including rights relating to being informed, accessing information, correcting inaccurate information, objecting to certain processing, and other rights recognized by the Data Privacy Act.</p>
<p>Requests concerning personal information should be handled through the designated privacy or system administrator according to the organization's approved procedure.</p>
<h4 class="about-h3">Children's and Minors' Information</h4>
<p>If REDFLOW processes information involving minors, additional safeguards and appropriate consent or authorization requirements must be considered.</p>
<p>The system should not assume that ordinary user registration is sufficient for the processing of a minor's sensitive personal information.</p>
<p>Any collection involving minors should follow applicable law, institutional requirements, and guidance from the appropriate privacy and research authorities.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Terms and Conditions</h3>
<h4 class="about-h3">Acceptance of the Terms</h4>
<p>By using REDFLOW, an authorized user acknowledges that he or she has read and understood the applicable Terms and Conditions, Privacy Policy, and User Agreement.</p>
<p>Use of the system is subject to the user's authorized role and the rules established by the system administrator and responsible institution.</p>
<h4 class="about-h3">Authorized Use</h4>
<p>REDFLOW may only be used for legitimate purposes connected with blood-donation coordination, donor information management, administration, research or approved institutional activities.</p>
<p>Users must not use the system for personal, commercial, discriminatory, fraudulent, or unauthorized purposes.</p>
<h4 class="about-h3">Prohibited Activities</h4>
<p>Users must not:</p>
<ul class="about-list">
  <li>Access another person's account without authorization.</li>
  <li>View donor information without a legitimate need.</li>
  <li>Copy or download donor information for unauthorized purposes.</li>
  <li>Share donor information through unauthorized channels.</li>
  <li>Sell, publish, or distribute donor information.</li>
  <li>Modify records without authorization.</li>
  <li>Enter knowingly false information.</li>
  <li>Use the system to impersonate another person.</li>
  <li>Attempt to bypass access controls.</li>
  <li>Attempt to obtain information beyond the user's assigned permissions.</li>
  <li>Use the system to make independent medical decisions.</li>
  <li>Represent REDFLOW as a hospital, blood bank, laboratory, or medical service.</li>
  <li>Use REDFLOW as a substitute for emergency medical services.</li>
</ul>
<h4 class="about-h3">Medical Disclaimer</h4>
<p>REDFLOW is an information-management and coordination system. It does not provide medical diagnosis, medical treatment, blood transfusion, blood testing, or professional medical advice.</p>
<p>A donor appearing in the master list does not mean that the donor is automatically eligible to donate.</p>
<p>Blood type information in the system should not be considered sufficient for transfusion compatibility. Appropriate medical testing and professional procedures must be performed by authorized healthcare personnel.</p>
<h4 class="about-h3">Emergency Situations</h4>
<p>REDFLOW should not be considered an emergency-response replacement.</p>
<p>In an actual medical emergency, patients or their representatives should seek immediate assistance from appropriate healthcare facilities and emergency medical professionals.</p>
<h4 class="about-h3">Accuracy of Information</h4>
<p>Although reasonable efforts should be made to maintain accurate records, REDFLOW cannot guarantee that every donor record will always be current.</p>
<p>Donor availability, contact information, location, health condition, and eligibility may change.</p>
<p>Healthcare personnel must verify relevant information before any actual donation or transfusion-related action.</p>
<h4 class="about-h3">System Availability</h4>
<p>REDFLOW may occasionally be unavailable because of maintenance, technical problems, connectivity issues, server problems, security updates, or other circumstances.</p>
<p>The system administrators may temporarily restrict access when necessary to protect system security, donor information, or system integrity.</p>
<h4 class="about-h3">Account Responsibility</h4>
<p>Authorized users are responsible for protecting their account credentials.</p>
<p>Users should not share passwords or allow unauthorized individuals to use their accounts.</p>
<p>Any suspected unauthorized account access should be reported immediately to the responsible administrator.</p>
<h4 class="about-h3">Suspension or Termination</h4>
<p>Access may be suspended or terminated when a user violates the Terms and Conditions, misuses personal information, compromises system security, or uses REDFLOW for an unauthorized purpose.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> User Agreement</h3>
<p>By accessing and using REDFLOW, the user acknowledges and agrees that:</p>
<p>The user will use REDFLOW only for authorized and legitimate purposes.</p>
<p>The user will respect the privacy and confidentiality of donor information.</p>
<p>The user will not disclose, copy, photograph, reproduce, or distribute donor information without appropriate authorization.</p>
<p>The user understands that blood type and other health-related information may require heightened protection.</p>
<p>The user understands that REDFLOW does not determine medical eligibility.</p>
<p>The user understands that appearing in the donor master list does not guarantee availability or eligibility.</p>
<p>The user agrees to provide accurate information when authorized to create or update records.</p>
<p>The user agrees not to manipulate, falsify, or intentionally damage donor records.</p>
<p>The user agrees to protect system credentials and report suspected security incidents.</p>
<p>The user understands that authorized healthcare personnel remain responsible for medical screening, blood typing confirmation, compatibility assessment, collection, storage, and transfusion-related procedures.</p>
<p>The user agrees to comply with applicable Philippine laws, institutional rules, privacy requirements, and REDFLOW policies.</p>
<p>Violation of this User Agreement may result in restriction or termination of system access and may lead to appropriate administrative or legal action where applicable.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Data Privacy and Security</h3>
<p>REDFLOW recognizes that protecting donor information is an important responsibility.</p>
<p>The system shall apply privacy-by-design principles where appropriate. Access should be limited according to user roles, and sensitive information should not be unnecessarily exposed.</p>
<p>The system may use administrative roles such as:</p>
<p>Administrator — responsible for authorized system management, user management, donor-record management, security controls, and administrative monitoring.</p>
<p>Authorized Staff — may access only the information necessary for assigned duties.</p>
<p>Donor — may be allowed to view or manage permitted information relating to his or her own record, depending on the approved system design.</p>
<p>Where the project is being used for research or academic evaluation, research data should be managed separately and according to the approved research protocol, informed consent documents, institutional requirements, and applicable privacy rules.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Data Retention and Disposal</h3>
<p>REDFLOW shall establish a documented retention period appropriate to the project's purpose.</p>
<p>When information is no longer necessary, the responsible organization should follow an approved disposal procedure.</p>
<p>Depending on the type of information and applicable requirements, disposal may involve secure deletion, destruction of physical copies, anonymization, or another approved method that prevents unauthorized recovery or further identification.</p>
<p>The Data Privacy Act provides that personal information should generally be retained only for as long as necessary for the purposes for which it was obtained, subject to applicable legal and other recognized exceptions.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Important Limitations of REDFLOW</h3>
<p>REDFLOW is not:</p>
<ul class="about-list">
  <li>A hospital.</li>
  <li>A blood bank.</li>
  <li>A blood collection unit.</li>
  <li>A laboratory.</li>
  <li>A blood storage facility.</li>
  <li>A transfusion service.</li>
  <li>A medical diagnostic system.</li>
  <li>A substitute for professional healthcare services.</li>
  <li>A guarantee of blood availability.</li>
  <li>A guarantee of donor eligibility.</li>
  <li>A replacement for medical compatibility testing.</li>
</ul>
<p>REDFLOW is intended to support information management and coordination.</p>
<p>Under RA 7719, blood banks and blood collection units are subject to regulatory requirements, and blood collection activities are connected to authorized facilities and professional standards.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Responsible Use of Blood Type Information</h3>
<p>Blood type information may be useful for identifying potential donors, but it should not be treated as the sole basis for determining whether blood can safely be transfused.</p>
<p>The actual medical decision must be made by qualified healthcare professionals using appropriate procedures and testing.</p>
<p>The REDFLOW master list is therefore a coordination resource rather than a clinical compatibility system.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Privacy and Confidentiality Statement</h3>
<p>All authorized users of REDFLOW are expected to treat donor information as confidential.</p>
<p>Personal information must not be accessed out of curiosity, shared with friends or unauthorized individuals, posted publicly, or used for purposes unrelated to the approved function of the system.</p>
<p>The fact that an individual is registered as a potential blood donor should not be treated as information that can automatically be published or publicly distributed.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Legal Compliance Statement</h3>
<p>REDFLOW is designed with consideration of applicable Philippine privacy and blood-donation laws, particularly Republic Act No. 10173, the Data Privacy Act of 2012, and Republic Act No. 7719, the National Blood Services Act of 1994.</p>
<p>RA 10173 establishes protections for personal information and requires lawful processing consistent with transparency, legitimate purpose, and proportionality.</p>
<p>RA 7719 promotes voluntary blood donation and establishes standards and regulatory requirements relating to blood services.</p>
<p>These laws should not be interpreted as authorizing REDFLOW to perform activities that legally belong to hospitals, blood banks, blood collection units, laboratories, physicians, medical technologists, nurses, or other authorized healthcare professionals.</p>
</div>
<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Acknowledgment</h3>
<p>REDFLOW recognizes that technology can support community blood-donation coordination, but technology must operate within appropriate medical, ethical, legal, and privacy boundaries.</p>
<p>The objective of REDFLOW is to organize information, improve coordination, and support voluntary blood-donation initiatives in Irosin while respecting the privacy and rights of donors and other individuals whose information may be processed.</p>
<p>The system shall prioritize responsible information management, confidentiality, data security, accuracy, authorized access, and appropriate coordination with qualified healthcare personnel.</p>
<p>By using REDFLOW, authorized users acknowledge their responsibility to protect personal information and to use the system only for its declared and legitimate purposes.</p>
</div>
                    </div>
                </div>
                <div id="faqSubPanel" class="about-subpanel">
                    <div class="about-card">
<p class="about-hero">Frequently Asked Questions about REDFLOW, Data Privacy, and Blood Donation Laws.</p>

<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> About REDFLOW</h3>
<div class="faq-list">
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>1. What is REDFLOW?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>REDFLOW is a digital information and coordination system that maintains an organized master list of voluntary blood donors in Irosin, including blood type and general location information, to help authorized personnel identify potential donors. It was developed to support Irosin District Hospital and local blood donation coordination efforts with faster, more organized recordkeeping.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>2. Is REDFLOW a hospital, blood bank, or medical facility?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>No. REDFLOW is an information-management and coordination system only. It does not collect, store, test, or transfuse blood, and it does not perform medical screening or eligibility assessment. Actual blood collection, testing, and transfusion remain the responsibility of hospitals and licensed blood service facilities.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>3. Who can use REDFLOW?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>REDFLOW is intended for authorized Administrators, Staff, and registered Donors who have legitimate access granted by the responsible institution. Each role has different access levels to keep donor information secure and used only for its intended purpose.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>4. What information does REDFLOW contain?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>REDFLOW may contain a donor's name, blood type, barangay or general location, contact information, availability status, and verification status, collected only to the extent necessary for its declared purpose. No sensitive medical records or laboratory results are stored in the system.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>5. Does REDFLOW guarantee that a listed donor is available or eligible to donate?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>No. Appearing on the master list does not guarantee availability, medical eligibility, or compatibility. Final verification must always be performed by qualified healthcare personnel before any actual donation takes place.</p></div>
</div>
</div>
</div>

<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Data Privacy (RA 10173)</h3>
<div class="faq-list">
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>6. What is Republic Act No. 10173?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>RA 10173, the Data Privacy Act of 2012, protects individual personal information and requires that data be processed with transparency, legitimate purpose, and proportionality. REDFLOW follows this law when collecting, storing, and handling donor and staff information.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>7. What personal information does REDFLOW collect?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Only information reasonably necessary for donor coordination and account management, such as name, blood type, barangay, contact number, account credentials, and verification documents submitted during sign up. This information is used solely to support blood donation coordination within Irosin.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>8. How is my information kept secure?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>REDFLOW applies safeguards such as authorized account access, password protection, role-based access, and restricted access to sensitive records appropriate to the risks involved. These measures help prevent unauthorized viewing, editing, or sharing of donor data.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>9. Who can access my information in REDFLOW?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Access is limited to authorized users whose duties require it. Administrators have broader management access, while Staff may only access information necessary for their assigned tasks. Donors themselves are not given direct system access.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>10. Can I request correction or removal of my information?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Yes. Subject to applicable law, data subjects may request access to, correction of, or objection to the processing of their personal information through the designated system administrator. Requests are handled in accordance with the institution's data privacy procedures.</p></div>
</div>
</div>
</div>

<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> RA 7719 &amp; Blood Donation</h3>
<div class="faq-list">
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>11. What is Republic Act No. 7719?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>RA 7719, the National Blood Services Act of 1994, promotes voluntary blood donation and sets the legal framework and standards for blood banks and blood collection units in the Philippines. REDFLOW supports the spirit of this law by helping coordinate voluntary community donors.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>12. Does REDFLOW confirm my blood type for transfusion purposes?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>No. Blood type information in the master list is a coordination reference only. Appropriate medical testing and compatibility confirmation must be performed by authorized healthcare facilities before any transfusion is carried out.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>13. Who performs the actual blood donation and medical screening?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Qualified healthcare professionals and authorized blood-service facilities remain responsible for screening, collection, storage, and transfusion, not REDFLOW. The system's role ends at helping coordinate and locate potential donors.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>14. Can REDFLOW be used in a medical emergency?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>REDFLOW is not an emergency-response replacement. In an actual emergency, please seek immediate assistance from a hospital or authorized medical facility. Staff may still use REDFLOW afterward to help coordinate follow-up donor outreach.</p></div>
</div>
</div>
</div>

<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Account, Sign Up &amp; Verification</h3>
<div class="faq-list">
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>15. How do I create a Staff account in REDFLOW?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Tap "Sign up" on the login screen and complete the registration steps: Terms & Privacy consent, personal information, location, valid ID, selfie verification, and account password. Once submitted, your account will be reviewed before you can log in.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>16. Why do I need to submit a valid ID and selfie during sign up?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>ID and selfie verification help the Admin confirm the identity of Staff applicants before granting access to donor information, protecting the integrity and security of the system. This step also helps prevent fraudulent or duplicate account registrations.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>17. How long does admin approval take?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Your account will remain in "Pending" status until an Administrator reviews your submitted information and documents. You will be able to log in once your account is approved, and processing time may vary depending on Admin availability.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>18. What should I do if I forget my password?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Use the "Forgot Password" link on the login screen, or contact your system Administrator for assistance in resetting your account credentials. A verification code will be sent to your registered email to confirm your identity.</p></div>
</div>
</div>
</div>

<div class="about-section">
<h3 class="about-h2"><i class="fa-solid fa-circle-dot"></i> Using REDFLOW Responsibly</h3>
<div class="faq-list">
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>19. What are Staff and Admin users not allowed to do?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Users must not access accounts without authorization, view or share donor information without a legitimate need, modify records without authorization, or use REDFLOW to impersonate another person. These rules exist to protect donor privacy and system integrity.</p></div>
</div>
<div class="faq-item">
  <button class="faq-question" onclick="toggleFaqItem(this)"><span>20. What happens if I violate the Terms and Conditions?</span><i class="fa-solid fa-chevron-down faq-arrow"></i></button>
  <div class="faq-answer"><p>Access may be suspended or terminated, and appropriate administrative or legal action may follow, depending on the nature of the violation. The institution reserves the right to review any reported misuse of the system.</p></div>
</div>
</div>
</div>

                    </div>
                </div>
            </section>
            <!-- NOTIFICATIONS PAGE VIEW -->
            <section id="page-notifications" class="page-view">
                <div class="about-card">
                    <div class="notif-header-row">
                        <p class="about-hero" style="margin:0;">NOTIFICATIONS</p>
                        <button id="notifClearAllBtn" class="admin-bulk-delete-btn active" onclick="clearAllNotifications()"><i class="fa-solid fa-trash"></i> CLEAR ALL</button>
                    </div>
                    <div id="notificationsListContainer" class="notif-list-container">
                        <!-- Rendered dynamically by renderNotificationsView() -->
                    </div>
                </div>
            </section>
        </div>
      <!-- BOTTOM FUNCTIONAL NAVIGATION BAR -->
        <nav class="bottom-nav-bar">
            <button class="bottom-nav-item active" onclick="switchMainPage('home', this)">
                <svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                <span>Home</span>
            </button>
            <button class="bottom-nav-item" onclick="switchMainPage('events', this)">
                <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                <span>Create</span>
            </button>
            <button class="bottom-nav-item" onclick="switchMainPage('history', this)">
                <svg viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg>
                <span>Record</span>
            </button>
            <button class="bottom-nav-item" id="notifNavBtn" onclick="switchMainPage('notifications', this); renderNotificationsView(); setTimeout(markNotificationsAsRead, 1200);">
                <svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                <span>Notification</span>
                <span class="notif-badge-dot" id="notifBadgeDot" style="display:none;"></span>
            </button>
            <button class="bottom-nav-item" onclick="switchMainPage('about', this)">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7H2v2z"/></svg>
                <span>About Us</span>
            </button>
        </nav>
    </div>
    <!-- GLOBAL CUSTOM ALERT BOX - CLEARLY VISIBLE CARD FOR ALL SYSTEM NOTICES -->
    <div class="modal-overlay" id="alertBoxModal">
        <div class="modal-box alert-box-card type-info" id="alertBoxCard">
            <div class="alert-box-icon" id="alertBoxIcon"><i class="fa-solid fa-circle-info"></i></div>
            <h3 id="alertBoxTitle">Notice</h3>
            <p id="alertBoxMessage"></p>
            <div class="modal-buttons">
                <button class="modal-btn btn-confirm" style="flex:1;" onclick="closeModal('alertBoxModal')">OK</button>
            </div>
        </div>
    </div>
    <!-- LOGOUT CONFIRMATION MODAL -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal-box">
            <h3>Log Out</h3>
            <p>Are you sure you want to log out?</p>
            <div class="modal-buttons">
                <button class="modal-btn btn-cancel" onclick="closeModal('logoutModal')">Cancel</button>
                <button class="modal-btn btn-confirm" onclick="confirmLogout()">Okay</button>
            </div>
        </div>
    </div>
    <!-- BLOOD TYPE CONFIRMATION MODAL (same styled card as Logout, replaces native confirm()) -->
    <div class="modal-overlay" id="bloodTypeConfirmModal">
        <div class="modal-box">
            <h3>Confirm Blood Type</h3>
            <p id="bloodTypeConfirmMessage">Are you sure this is correct?</p>
            <div class="modal-buttons">
                <button class="modal-btn btn-cancel" onclick="closeModal('bloodTypeConfirmModal')">Cancel</button>
                <button class="modal-btn btn-confirm" onclick="confirmBloodTypeAndProceed()">Okay</button>
            </div>
        </div>
    </div>
    
    <!-- GENERIC CONFIRM MODAL (styled card like Logout — replaces every native confirm() in the app) -->
    <div class="modal-overlay" id="genericConfirmModal">
        <div class="modal-box">
            <h3 id="genericConfirmTitle">Please Confirm</h3>
            <p id="genericConfirmMessage">Are you sure?</p>
            <div class="modal-buttons">
                <button class="modal-btn btn-cancel" onclick="closeModal('genericConfirmModal')">Cancel</button>
                <button class="modal-btn btn-confirm" id="genericConfirmOkBtn" onclick="">Okay</button>
            </div>
        </div>
    </div>
