import { useLoggedInUser } from '../composables/use-logged-in-user'

export function changeTheme() {
    const { loggedInUser } = useLoggedInUser()
    const changeColour = (prop, color) => { document.documentElement.style.setProperty(prop, color) }
    const loadTheme = (themeIdx) => {
        const theme = loggedInUser?.value.preferences.themes[themeIdx]
        changeColour('--primary', theme["primary"])
        changeColour('--primary-alt', theme["primaryAlt"])
        changeColour('--light', theme["light"])
        changeColour('--light-alt', theme["lightAlt"])
        changeColour('--dark', theme["dark"])
        changeColour('--dark-alt', theme["darkAlt"])
        
        changeColour('--white', theme["white"])
        changeColour('--grey', theme["grey"])
        changeColour('--black', theme["black"])
    }

    return {
        loadTheme,
        changeColour,
    }
}