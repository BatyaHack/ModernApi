export default function  goLogin(data) {
    const token = data.data;
    localStorage.setItem('modernToken', token.token);
    window.location.pathname = '/';
}