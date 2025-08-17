import controller_0 from "../../controllers/hello_controller.js";
export const eagerControllers = {"hello": controller_0};
export const lazyControllers = {"clipboard": () => import("../../controllers/clipboard_controller.js"), "syntax-highlight": () => import("../../controllers/syntax_highlight_controller.js")};
export const isApplicationDebug = true;