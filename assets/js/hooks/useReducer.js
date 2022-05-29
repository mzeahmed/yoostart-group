export const formReducer = (state, event) => {
  return {
    ...state,
    [event.name]: event.value
  };
};