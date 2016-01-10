import { combineReducers } from 'redux'
import clips from './clips'
import files from './files'

const rootReducer = combineReducers({
  clips,
  files
})

export default rootReducer
