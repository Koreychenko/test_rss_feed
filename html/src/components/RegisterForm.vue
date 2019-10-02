<template>
  <el-row :gutter="24">
    <el-col :span="8" :offset="8"><div class="grid-content bg-purple">
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Email">
          <el-input v-on:input="checkEmail" placeholder="Please input email" v-model="form.email"><i v-if="valid"
                  class="el-icon-check el-input__icon"
                  slot="suffix">
          </i></el-input>
        </el-form-item>
        <el-form-item label="Password">
          <el-input placeholder="Please input password" v-model="form.password" show-password></el-input>
        </el-form-item>
        <el-form-item>
          <el-button :disabled="!valid" type="primary" @click="onSubmit">Register</el-button>
          <RouterLink to="/login"><el-button>Login</el-button></RouterLink>
        </el-form-item>
      </el-form>
    </div></el-col>
  </el-row>

</template>
<script>
  import axios from 'axios'
  import config from "../config/config";

  export default {
    data() {
      return {
        valid: false,
        form: {
          email: '',
          password: '',
        }
      }
    },
    methods: {
      checkEmail(value) {
        let _this = this;
        axios.post(config.api.CHECK, {email: value}).then(result => {
          _this.valid = result.data.valid;
        }).catch(result => {
          // eslint-disable-next-line
          console.log(result);
        });
      },
      onSubmit() {
        axios.post(config.api.REGISTER, {form: this.form}).then(result => {
          localStorage.setItem('token', result.data.token);
          this.$router.push({name: 'feed'})
        }).catch(result => {
          // eslint-disable-next-line
          console.log(result);
        });
      }
    }
  }
</script>

<style>
  .el-input__icon {
    color: #5daf34;
  }
</style>