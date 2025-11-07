import Toastify from "https://cdn.jsdelivr.net/npm/toastify-js/+esm";

const base = {
  duration: 3000,
  gravity: "top",
  position: "center",
};

export const toast = {
  success: (text, opts = {}) => {
    Toastify({
      ...base,
      ...opts,
      text,
      backgroundColor: "green",
    }).showToast();
  },
  error: (text, opts = {}) => {
    Toastify({
      ...base,
      ...opts,
      text,
      backgroundColor: "red",
    }).showToast();
  },
};
