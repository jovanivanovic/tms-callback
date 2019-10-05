import { Axios } from "../../helpers/axios";

export function submitCallback(data) {
    return new Promise((res, rej) => {
        Axios.post('/api/callback/submit', data)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            })
    })
}

export function getAvailableTimes(date) {
    return new Promise((res, rej) => {
        Axios.post('/api/callback/times', { date })
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            });
    });
}
