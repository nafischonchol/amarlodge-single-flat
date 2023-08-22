
<template>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active " id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                        aria-selected="true">{{ translate('Profile') }} {{ translate('Information')
                                        }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                        data-bs-target="#password" type="button" role="tab" aria-controls="password"
                                        aria-selected="false">{{ translate('Password') }} {{ translate('Change') }}</button>
                                </li>
                            </ul>
                            <div class="tab-content col-12 col-lg-12" id="myTabContent">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <Profile />
                                </div>
                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <Password />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--end row-->
</template>

<script>
import Profile from "@/pages/profile/profile-component.vue";
import Password from "@/pages/profile/password-component.vue";

export default {
    components: { Profile, Password }
};
</script>
