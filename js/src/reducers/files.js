import types from 'constants/files'

const initialState = []

export default function files(state = initialState, action) {
  switch (action.type) {
    case types.FILES_DROPPED:

    default:
      return state
  }
}
