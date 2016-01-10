const initialState = []
import types from 'constants/files'

export default function files(state = initialState, action) {
  switch (action.type) {
    case types.FILES_DROPPED:

    default:
      return state
  }
}
