<template>
  <el-row :gutter="24">
    <el-col :span="8" :offset="8"><div class="grid-content bg-purple">
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Email">
          <el-input v-on:input="checkEmail" placeholder="Please input email" v-model="form.email"></el-input>
        </el-form-item>
        <el-form-item label="Password">
          <el-input placeholder="Please input password" v-model="form.password" show-password></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">Register</el-button>
          <RouterLink to="/login"><el-button>Login</el-button></RouterLink>
        </el-form-item>
      </el-form>
    </div></el-col>
  </el-row>

</template>
<script>
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
      checkEmail(value) {
        // eslint-disable-next-line
        console.log(value);
      },
      onSubmit() {

      }
    }
  }
</script>