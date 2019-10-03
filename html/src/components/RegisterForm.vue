<template>
    <el-row :gutter="24">
        <el-col :span="8" :offset="8">
            <div class="grid-content bg-purple">
                <el-card class="box-card">
                    <h3>Register:</h3>
                    <el-form ref="form" :model="form">
                        <el-form-item>
                            <el-input v-on:input="checkEmail" placeholder="Please input email" v-model="form.email"><i
                                    v-if="valid"
                                    class="el-icon-check el-input__icon"
                                    slot="suffix">
                            </i></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-input placeholder="Please input password" v-model="form.password"
                                      show-password></el-input>
                        </el-form-item>
                        <el-form-item size="large">
                            <el-button :disabled="!valid" type="primary" @click="onSubmit">Register</el-button>
                            <RouterLink to="/login">
                                <el-button>Login</el-button>
                            </RouterLink>
                        </el-form-item>
                    </el-form>
                </el-card>
            </div>
        </el-col>
    </el-row>

</template>
<script>
    import api from "../services/api";

    export default {
        data() {
            return {
                valid: false,
                request: null,
                form: {
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            checkEmail(value) {
                if (this.request) {
                    clearTimeout(this.request);
                }
                this.request = setTimeout(() => {
                    this.getEmailResult(value);
                }, 1000);
            },
            async getEmailResult(value) {
                this.valid = await api.checkEmail(value).catch(error => {

                });
            },
            async onSubmit() {
                await api.register(this.form).then(() => {
                    this.$router.push({name: 'feed'})
                }).catch(error => {

                });
            }
        }
    }
</script>

<style>
    .el-input__icon {
        color: #5daf34;
    }

    .el-button + a {
        margin-left: 10px;
    }
</style>