interface IPosting {
    id: number,
    job_title: string,
    employer: string,
}

type PostingState = {
    postings: IPosting[]
}

type PostingAction = {
    type: string
    posting: IPosting
}

type DispatchType = (args: PostingAction) => PostingAction