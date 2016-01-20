# ifndef _Stack_h

struct Node;
typedef struct node *PtrToNode;
typedef PrtToNode Stack;

int IsEmpty(Stack S);
Stack CreateStack(void);
void DisposeStack(Stack S);
void MakeEmpty(Stack S);
void Push(ElementType X, Stack S);
ElementType Top(Stack S);
void Pop(Stack S);

#endif /* _Stack_h */

struct Node{
    ElementType Element;
    PtrToNode Next;
};

int IsEmpty(Stack S){
    return S->Next == NULL;
}

Stack CreateStack(void){
    Stack S;

    S =malloc(sizeof(struct Node));
    if(S == NULL)
        FatalError("Out of space");
    S->Next == NULL;
    MakeEmpty(S);
    return S;
}

void MakeEmpty(Stack S){
    if(S == NULL){
        Error("must use CreateStack first");
    }else{
        while(!IsEmpty(S))
            Pop(S);
    }
}

void Push(ElementType X, Stack S){
    PtrToNode TmpCell;

    TmpCell = malloc(sizeof(struct Node));
    if(TmpCell == NULL)
        FatalError("Out of space");
    else{
        TmpCell->Element = X;
        TmpCell->Next = S->Next;
        S->Next = TmpCell;
    }
}

ElementType Top(Stack S){
    if(!IsEmpty(S))
        return S->Next->Element;
    Error("Empty stack");
    return 0; // Return value used to avoid warning
}

void Pop(Stack S){
    PtrToNode FirstCell;

    if(IsEmpty(S)){
        Error("Empty stack");
    }else{
        FirstCell = S->Next;
        S->Next = S->Next->Next;
        free(FirstCell);
    }
}

/* =================================================== */
/**
 * Array define
 */
/* =================================================== */
#ifndef _Stack_h

struct StackRecord;
typedef struct StackRecord *Stack;

int IsEmpty(Stack S);
int IsFull(Stack S);
Stack CreateStack(int MaxElements);
void DisposeStack(Stack S);
void MakeEmpty(Stack S);
void Push(ElementType x, Stack S);
ElementType Top(Stack S);
void Pop(Stack S);
ElementType TopAndPop(Stack S);

#endif /* _Stack_h */

#define EmptyTOS -1
#define MinStackSize 5

struct StackRecord{
    int Capacity;
    int TopOfStack;
    ElementType *Array;
};

Stack CreateStack(int MaxElements){
    Stack S;

    if(MaxElements < MinStackSize)
        Error("Stack size is too small");

    S = malloc(sizeof(struct StackRecord));
    if(S == NULL)
        FatalError("Out of space");

    S->Array = malloc(sizeof(ElementType) * MaxElements);
    if(S->Array == NULL)
        FatalError("Out of space");
    S->Capacity = MaxElements;
    MakeEmpty(S);

    return S;
}

void DisposeStack(Stack S){
    if(S != NULL){
        free(S->Array);
        free(S);
    }
}

int IsEmpty(Stack S){
    return S->TopOfStack == EmptyTOS;
}

void MakeEmpty(Stack S){
    S->TopOfStack = EmptyTOS;
}

void Push(ElementType X, Stack S){
    if(IsFull(S))
        Error("Full stack");
    else
        S->Array[++S->TopOfStack] =X;
}

ElementType Top(Stack S){
    if(!IsEmpty(S))
        return S->Array[S->TopOfStack];
    Error("Empty stack");
    return 0;
}

void Pop(Stack S){
    if(IsEmpty(S))
        Error("Empty stack");
    else{
        S->TopOfStack--;
    }
}

ElementType TopAndPop(Stack S){
    if(!IsEmpty(S)){
        return S->Array[S->TopOfStack--];
    }
    Error("Empty stack");
    return 0;
}