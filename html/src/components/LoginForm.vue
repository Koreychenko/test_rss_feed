<template>
    <div>
        <el-row :gutter="24">
            <el-col :span="8" :offset="8">
                <div class="grid-content bg-purple">
                    <el-card class="box-card">
                        <h3>Login:</h3>
                        <el-form ref="form" :model="form">
                            <el-form-item>
                                <el-input placeholder="Please input email" v-model="form.email"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-input placeholder="Please input password" v-model="form.password"
                                          show-password></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="onSubmit">Login</el-button>
                                <RouterLink to="/register">
                                    <el-button>Register</el-button>
                                </RouterLink>
                            </el-form-item>
                        </el-form>
                    </el-card>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script>

    import api from "../services/api";

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            async onSubmit() {
                await api.login(this.form).then(result => {
                    this.$router.push({name: 'feed'})
                }).catch(error => {

                });
            }
        }
    }
</script>
<style>
    .el-button + a {
        margin-left: 10px;
    }
</style>