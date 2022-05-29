import { useState } from 'react';

/**
 * Gere la validation des formulaires
 *
 * @param initialState
 * @param validations
 * @param onSubmit
 * @returns {{touched: {}, values: {}, isValid: unknown, submitHandler: submitHandler, changeHandler: changeHandler, errors: unknown}}
 */
export default function useForm (initialState = {}, validations = [], onSubmit = () => {}) {
  const { isValid: initialIsValid, errors: initialErrors } = validate(validations, initialState);
  const [values, setValues] = useState(initialState);
  const [errors, setErrors] = useState(initialErrors);
  const [isValid, setValid] = useState(initialIsValid);
  const [touched, setTouched] = useState({});

  const changeHandler = (event) => {
    const newValues = { ...values, [event.target.name]: event.target.value };
    const { isValid, errors } = validate(validations, newValues);
    setValues(newValues);
    setValid(isValid);
    setErrors(errors);
    setTouched({ ...touched, [event.target.name]: true });
  };

  const submitHandler = (event) => {
    event.preventDefault();
    onSubmit(values);
  };

  return { values, changeHandler, isValid, errors, touched, submitHandler };
}