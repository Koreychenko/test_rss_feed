import axios from 'axios'
import config from "../config/config";
import Message from "element-ui/packages/message/src/main";

export default {
    getTransport() {
        let axiosInstance = axios.create({
            headers: {'X-token': localStorage.getItem('token')}
        });

        const errorHandler = (error) => {

            return Promise.reject({...error})
        };

        const successHandler = (response) => {
            if ('token' in response.data) {
                localStorage.setItem('token', response.data.token);
            }
            if ('error' in response.data) {
                if (response.data.error == 'noauth') {
                    return Promise.reject('noauth');
                } else {
                    Message({'type': 'error', 'message': response.data.error});
                }
            }
            if ('errors' in response.data) {
                for (let error in response.data.errors) {
                    Message({'type': 'error', 'message': response.data.errors[error]});
                }
                return Promise.reject();
            }
            return response
        };

        axiosInstance.interceptors.response.use(
            response => successHandler(response),
            error => errorHandler(error)
        );
        return axiosInstance;
    },
    getFeed() {
        return new Promise(async (resolve, reject) => {
            try {
                const result = await this.getTransport().get(config.api.FEED);
                resolve({'feed': result.data.feed, 'loading': false, words: result.data.mostFrequentWords});
            } catch (error) {
                reject(error)
            }
        })
    },
    checkEmail(email) {
        return new Promise(async (resolve, reject) => {
            try {
                const result = await this.getTransport().post(config.api.CHECK, {'email': email});
                resolve(result.data.valid);
            } catch (error) {
                reject(error)
            }
        })
    },
    register(form) {
        return new Promise(async (resolve, reject) => {
            try {
                const token = await this.getTransport().post(config.api.REGISTER, {form: form});
                resolve(token);
            } catch (error) {
                reject(error)
            }
        })
    },
    login(form) {
        return new Promise(async (resolve, reject) => {
            try {
                const token = await this.getTransport().post(config.api.LOGIN, {form: form});
                resolve(token);
            } catch (error) {
                reject(error)
            }
        })
    }
}