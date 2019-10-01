<template><div>
  <el-row :gutter="24">
    <el-col :span="8" :offset="8"><div class="grid-content bg-purple">
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Email">
          <el-input placeholder="Please input email" v-model="form.email"></el-input>
        </el-form-item>
        <el-form-item label="Password">
          <el-input placeholder="Please input password" v-model="form.password" show-password></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">Login</el-button>
          <RouterLink to="/register"><el-button>Register</el-button></RouterLink>
        </el-form-item>
      </el-form>
    </div></el-col>
  </el-row>
</div>
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
      onSubmit() {

      }
    }
  }
</script>