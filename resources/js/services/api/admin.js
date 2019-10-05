import { Axios } from "../../helpers/axios";

export function getAllCallbacks() {
    return new Promise((res, rej) => {
        Axios.get('/api/admin/callbacks')
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            })
    })
}

export function getCallback(id) {
    return new Promise((res, rej) => {
        Axios.get(`/api/admin/callbacks/${id}`)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            });
    });
}

export function archiveCallback(id) {
    return new Promise((res, rej) => {
        Axios.post(`/api/admin/callbacks/${id}/archive`)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            });
    });
}

export function commentCallback(id, comment) {
    return new Promise((res, rej) => {
        Axios.post(`/api/admin/callbacks/${id}/comment`, { content: comment })
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                rej(err);
            });
    });
}
