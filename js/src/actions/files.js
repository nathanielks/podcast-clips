import types from 'constants/files'

export const filesDropped = (files) => {
  console.log('Received files: ', files);
  return {
    type: types.FILES_DROPPED,
    files
  }
}
