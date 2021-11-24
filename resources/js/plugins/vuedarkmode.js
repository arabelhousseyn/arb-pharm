import Vue from "vue"
import VueDarkMode from "@growthbunker/vuedarkmode"

Vue.use(VueDarkMode,{
    theme: "dark",
    components: [
        // Base components
        "alert", "avatar", "badge", "button", "divider", "heading", "icon",  "progress-bar",  "spinner",
    
        // Field components
        "checkbox", "file", "image-uploader", "input", "input-numeric", "label", "message", "radios", "select", "tabs", "textarea", "toggle"
      ]
})