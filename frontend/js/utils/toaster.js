import Toastify from "https://cdn.jsdelivr.net/npm/toastify-js/+esm";

export const toast = (text, { type, ...opts } = {}) =>
  Toastify({
    duration: 3000,
    gravity: "top",
    position: "center",
    close: true,
    ...opts,
    text,
    className: type,
  }).showToast();

toast.success = (text, opts = {}) => toast(text, { ...opts, type: "success" });
toast.error = (text, opts = {}) => toast(text, { ...opts, type: "error" });
toast.info = (text, opts = {}) => toast(text, { ...opts, type: "info" });
toast.warning = (text, opts = {}) => toast(text, { ...opts, type: "warning" });
